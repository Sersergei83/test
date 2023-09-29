<?php
abstract class Unit
{
    abstract public function addUnit(Unit $unit):void;
    abstract public function removeUnit(Unit $unit):void;
    abstract public function bombardStrenght():int;
}
class UnitException extends \Exception
{

}
class Archer extends Unit
{
    public function addUnit(Unit $unit): void
    {
        // TODO: Implement addUnit() method.
        throw new UnitException(get_class($this)."являеться листом");
    }
    public function removeUnit(Unit $unit): void
    {
        // TODO: Implement removeUnit() method.
        throw new UnitException(get_class($this)."являеться листом");
    }

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
class Army extends Unit
{
    private array $units=[];
    public function addUnit(Unit $unit):void
    {
        if(in_array($unit,$this->units,true))
        {
            return;
        }
        $this->units[]=$unit;
    }
    public function removeUnit(Unit $unit): void
    {
        // TODO: Implement removeUnit() method.
        $idx=array_search($unit,$this->units,true);
        if (is_int($idx))
        {
            array_splice($this->units,$idx,1,[]);
        }
    }


    public function bombardStrenght():int
    {
        $ret=0;
        foreach ($this->units as $unit)
        {
            $ret +=$unit->bombardStrenght();
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