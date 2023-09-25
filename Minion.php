<?php
abstract class Employee
{
    private static $types = ['Minion','CluedUp', 'WellConnected'];
    public static function recruit(string $name):Employee
    {
        $num=rand(1,count(self::$types))-1;
        $class= __NAMESPACE__ . "\\". self::$types[$num];
        return new $class($name);
    }
    public function __construct(protected string $name)
    {
    }
    abstract public function fire():void;
}
class WellConnected extends Employee
{
    public function fire(): void
    {
        // TODO: Implement fire() method.
        print "$this->name : я позвоню папе \n";
    }
}

class Minion extends Employee
{
    public function fire(): void
    {
        // TODO: Implement fire() method.
        print "$this->name: я уберу со стола\n";
    }
}
class ClueUp extends Employee
{
    public function fire(): void
    {
        // TODO: Implement fire() method.
        print "$this->name: я візову адвоката \n";
    }
}
class NastyBoss
{
    private array $employees =[];
    public function addEmployee(Employee $employee):void
    {
        $this->employees[]= $employee;
    }
    public function projectFails():void
    {
        if(count($this->employees)>0)
        {
            $emp=array_pop($this->employees);
            $emp->fire();
        }
    }
}

$boss = new NastyBoss();
$boss->addEmployee(Employee::recruit("Игорь"));
$boss->addEmployee(Employee::recruit("Владимир"));
$boss->addEmployee(Employee::recruit("Мария"));
$boss->projectFails();
$boss->projectFails();
$boss->projectFails();