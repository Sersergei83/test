<?php
interface Observable
{
    public function attach(Observer $observer):void;
    public function detach(Observer $observer):void;
    public function notify():void;
}
class Login implements Observable
{
    public const LOGIN_USER_UNKOWN=1;
    public const LOGIN_WRONG_PASS =2;
    public const LOGIN_ACCESS =3;
    private array $observers=[];
    public function attach(Observer $observer): void
    {
        // TODO: Implement attach() method.
        $this->observers[]=$observer;
    }
    public function detach(Observer $observer): void
    {
        $this->observers=array_filter(
            $this->observers,
            function ($a) use ($observer)
            {
                return (!($a === $observer));
            }
        );
    }
    public function notify(): void
    {
        // TODO: Implement notify() method.
        foreach ($this->observers as $obs)
        {
            $obs->update($this);
        }
    }

    public function handleLogin(string $user, string $pass,string $ip):bool
    {
        $isvalid = false;
        switch (rand(1,3))
        {
            case 1:
                $this->setStatus(self::LOGIN_ACCESS,$user,$ip);
                $isvalid=true;
                break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS,$user,$ip);
                $isvalid=false;
                break;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKOWN,$user,$ip);
                $isvalid=false;
                break;
        }
        $this->notify();
        return $isvalid;
    }

    public function setStatus(int $status,string $user, string $ip):void
    {
        $this->status=[$status,$user,$ip];
}

    /**
     * @return array
     */
    public function getStatus(): array
    {
        return $this->status;
    }

}
interface Observer
{
    public function update(Observable $observable):void;
}
class LoginAnalytics implements Observer
{
    public function update(Observable $observable): void
    {
        // TODO: Implement update() method
        $status= $observable->getStatus();
        print __CLASS__.":обработка информации о состоянии\n";
    }
}
abstract class LoginObserver implements Observer
{
    private Login $login;

    public function __construct(Login $login)
    {
        $this->login=$login;
        $login->attach($this);
    }
    public function update(Observable $observable): void
    {
        // TODO: Implement update() method.
        if ($observable===$this->login)
        {
            $this->doUpdate($observable);
        }
    }
    abstract public function doUpdate(Login $login):void;
}
class SecurityMonitor extends LoginObserver
{
    public function doUpdate(Login $login): void
    {
        // TODO: Implement doUpdate() method.
        $status =$login->getStatus();
        if ($status[0]==Login::LOGIN_WRONG_PASS)
        {
            print __CLASS__.":письмо сисадмину\n";
        }
    }
}
class GeneralLogger extends LoginObserver
{
    public function doUpdate(Login $login): void
    {
        // TODO: Implement doUpdate() method.
        $status=$login->getStatus();
        print __CLASS__."добавление данных о входе в журнал\n";
    }
}
class PartnershipTool extends LoginObserver
{
    public function doUpdate(Login $login): void
    {
        // TODO: Implement doUpdate() method.
        $status=$login->getStatus();
        print __CLASS__.":становка куков при соответствии списку\n";
    }
}
$login=new Login();
new SecurityMonitor($login);
new GeneralLogger($login);
new PartnershipTool($login);
$login->handleLogin("Vasya","dfdfs","172.16.8.208");