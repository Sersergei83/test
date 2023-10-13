<?php
abstract class Command
{
    abstract public function execute(CommandContext $context): bool;
}

class CommandContext
{
    private array $params = [];
    private string $error = "";

    public function __construct()
    {
        $this->params = $_REQUEST;
    }

    public function addParam(string $key, $val): void
    {
        $this->params[$key] = $val;
    }

    public function get(string $key): ?string
    {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        }
        return null;
    }

    public function setError($error): string
    {
        $this->error = $error;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
class CommandFactory
{
    private static string $dir = 'commands';

    public static function getCommand(string $action = 'Default'): Command
    {
        if (preg_match('/\W/', $action)) {
            throw new \Exception("illegal characters in action");
        }

        $class = __NAMESPACE__ . UCFirst(strtolower($action)) . "Command";

        if (! class_exists($class)) {
            throw new CommandNotFoundException("no '$class' class located");
        }

        $cmd = new $class();

        return $cmd;
    }
}
class Controller
{
    private CommandContext $context;

    public function __construct()
    {
        $this->context = new CommandContext();
    }

    public function getContext(): CommandContext
    {
        return $this->context;
    }

    public function process(): void
    {
        $action = $this->context->get('action');
        $action = (is_null($action)) ? "default" : $action;
        $cmd = CommandFactory::getCommand($action);

        if (! $cmd->execute($this->context)) {
            // handle failure
        } else {
            // success
            // dispatch view
        }
    }
}
class CommandNotFoundException extends \Exception
{
}
class LoginCommand extends Command
{

    public function execute(CommandContext $context): bool
    {
        $manager = Registry::getAccessManager();
        $user = $context->get('username');
        $pass = $context->get('pass');
        $user_obj = $manager->login($user, $pass);

        if (is_null($user_obj)) {
            $context->setError($manager->getError());
            return false;
        }

        $context->addParam("user", $user_obj);

        return true;
    }
}
class Registry
{
    public static function getMessageSystem(): MessageSystem
    {
        return new MessageSystem();
    }

    public static function getAccessManager(): AccessManager
    {
        return new AccessManager();
    }
}
class AccessManager
{
    public function login(string $user, string $pass): User
    {
        $ret = new User($user);
        return $ret;
    }

    public function getError(): string
    {
        return "move along now, nothing to see here";
    }
}
class User
{
    public function __construct(private string $name)
    {
    }
}
class FeedbackCommand extends Command
{
    public function execute(CommandContext $context): bool
    {
        $msgSystem = Registry::getMessageSystem();
        $email = $context->get('email');
        $msg   = $context->get('msg');
        $topic = $context->get('topic');
        $result = $msgSystem->send($email, $msg, $topic);

        if (! $result) {
            $context->setError($msgSystem->getError());
            return false;
        }

        return true;
    }
}
class DefaultCommand extends Command
{

    public function execute(CommandContext $context): bool
    {
        // default command
        return true;
    }
}
$controller=new Controller();
$context = $controller->getContext();
$context->addParam('action','login');
$context->addParam('username','Иван');
$context->addParam('pass','tiddles');
$controller->process();
print $context->getError();