<?php
include_once "composite.php";

class TileForce
{
    private int $x;
    private int $y;
    private array $units=[];

    public function __construct(int $x,int $y,UnitAcquisition $acq)
    {
        $this->x=$x;
        $this->y=$y;
        $this->units=$acq->getUnits($this->x,$this->y);
    }

    public function firepower():int
    {
        $power=0;
        foreach ($this->units as $unit)
        {
            $power+=$unit->bombardStrength();
        }
        return $power;
    }
}
class UnitAcquisition
{
    public function getUnits(int $x,int $y):array
    {
        $army= new Army();
        $army->addUnit(new Archer());
        $found=[
            new Cavalry(),
            new NullUnit(),
            new LaserCannonUnit(),
            $army
        ];
        return $found;
    }
}
class NullUnit extends Unit
{
    public function bombardStrength(): int
    {
        return 0;// TODO: Implement bombardStrength() method.
    }
    public function getHealth(): int
    {
        return 0; // TODO: Change the autogenerated stub
    }
    public function getDepth(): int
    {
        return 0; // TODO: Change the autogenerated stub
    }
}
$acquirer=new UnitAcquisition();
$tileforces=new TileForce(4,2,$acquirer);
$power=$tileforces->firepower();
print "Огневая мощ:{$power}\n";