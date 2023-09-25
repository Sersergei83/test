<?php
include_once "lesson.php";
class RegistrationMgr
{
    public function register (Lesson $lesson):void
    {
        $notifier=Notifier::getNotifier();
        $notifier->inform("new Lesson: cost ({$lesson->cost()})");
    }
}
abstract class Notifier
{
    public static function getNotifier():Notifier
    {
        if(rand(1,2) === 1)
        {
            return new MailNotifier();
        }
        else
        {
            return new TextNotifier();
        }
    }
    abstract public function inform($message): void;
}
class MailNotifier extends Notifier
{
    public function inform($message): void
    {
       print "Уведомление почтой:{$message}\n";// TODO: Implement inform() method.
    }
}
class TextNotifier extends Notifier
{
    public function inform($message): void
    {
        print "Уведомление текстом: {$message}\n";// TODO: Implement inform() method.
    }
}
$lessons1=new Seminar(4, new TimeCostStrategy());
$lessons2=new Lecture(4,new FixedCostStrategy());
$mgr =new RegistrationMgr();
$mgr->register($lessons1);
$mgr->register($lessons2);


