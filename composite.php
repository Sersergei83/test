<?php
abstract class Unit
{

    abstract public function bombardStrenght():int;
}
class Archer extends Unit
{
    public function bombardStrenght(): int
    {
        // TODO: Implement bombardStrenght) method.
        return 4;
    }
}
class LaserCannonUnit extends Unit
{
    public function bombardStrenght(): int
    {
        // TODO: Implement bombardStrenght method.
        return 44;
    }
}
class Army
{
    private array $units=[];
    public function addUnit(Unit $unit):void
    {
        array_push($this->units,$unit);
    }
    public function addArmy(Army $army):void
    {
        array_push($this->armies,$army);
    }
    public function bombardStrenght():int
    {
        $ret=0;
        foreach ($this->units as $unit)
        {
            $ret +=$unit->bombardStrenght();
        }
        foreach ($this->armies as $army)
        {
            $ret +=$army->bobombardStrenght();
        }
        return $ret;
    }
}

$unit1=new Archer();
$unit2=new LaserCannonUnit();
$army=new Army();
$army->addUnit($unit1);
$army->addUnit($unit2);
print $army->bombardStrenght();