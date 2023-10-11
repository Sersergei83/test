<?php
abstract class Unit
{
    // ...
    /* /listing 11.41 */
    protected int $health = 10;
    protected int $depth = 0;

    public function getComposite(): ?Unit
    {
        return null;
    }

    abstract public function bombardStrength(): int;

    public function getHealth(): int
    {
        return $this->health;
    }

    public function isNull(): bool
    {
        return false;
    }
    /* listing 11.41 */
    public function accept(ArmyVisitor $visitor): void
    {
        $refthis = new \ReflectionClass(get_class($this));
        $method = "visit" . $refthis->getShortName();
        $visitor->$method($this);
    }

    protected function setDepth($depth): void
    {
        $this->depth = $depth;
    }

    public function getDepth(): int
    {
        return $this->depth;
    }
}
abstract class CompositeUnit extends Unit
{
    // ...

    /* /listing 11.42 */
    private array $units = [];

    public function getComposite(): Unit
    {
        return $this;
    }

    public function units(): array
    {
        return $this->units;
    }

    public function removeUnit(Unit $unit): void
    {
        $units = [];

        foreach ($this->units as $thisunit) {
            if ($unit !== $thisunit) {
                $units[] = $thisunit;
            }
        }

        $this->units = $units;
    }

    public function getHealth(): int
    {
        $health = 0;

        foreach ($this->units() as $unit) {
            $health += $unit->getHealth();
        }

        return $health;
    }

    /* listing 11.42 */
    public function addUnit(Unit $unit): void
    {
        foreach ($this->units as $thisunit) {
            if ($unit === $thisunit) {
                return;
            }
        }

        $unit->setDepth($this->depth + 1);
        $this->units[] = $unit;
    }

    public function accept(ArmyVisitor $visitor): void
    {
        parent::accept($visitor);

        foreach ($this->units as $thisunit) {
            $thisunit->accept($visitor);
        }
    }
}
class UnitException extends \Exception
{

}
class Archer extends Unit
{
    public function bombardStrength(): int
    {
        return 4;
    }
}
class Cavalry extends Unit
{
    public function bombardStrength(): int
    {
        return 2;// TODO: Implement bombardStrenght() method.
    }
}
class LaserCannonUnit extends Unit
{
    public function bombardStrength(): int
    {
        // TODO: Implement bombardStrenght method.
        return 44;
    }
}
class Army extends CompositeUnit
{

    public function bombardStrength(): int
    {
        $strength = 0;
        foreach ($this->units() as $unit) {
            $strength += $unit->bombardStrength();
        }
        return $strength;
    }
}
class UnitScript
{
    public static function joinExisting(
        Unit $newUnit,
        unit $occupyingUnit
    ):CompositeUnit
    {
        $comp=$occupyingUnit->getComposite();
        if (!is_null($comp))
        {
            $comp->addUnit($newUnit);
        }
        else
        {
            $comp=new Army();
            $comp->addUnit($occupyingUnit);
            $comp->addUnit($newUnit);
        }
        return $comp;
    }
}

$main_army=new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannonUnit());
$textdump = new TextDumpArmyVisitor();
$main_army->accept($textdump);
print $textdump->getText();





