<?php
abstract class Tile
{
    abstract public function getWealthFactor():int;
}
class Plains extends Tile
{
    private int $wealthfactor=2;
    public function getWealthFactor(): int
    {
        // TODO: Implement getWealthFactor() method.
        return $this->wealthfactor;
    }
}
abstract class TileDecorator extends Tile
{
    protected Tile $tile;
    public function __construct(Tile $tile)
    {
        $this->tile=$tile;
    }
}

class DiamondDecorator extends TileDecorator
{
    public function getWealthFactor(): int
    {
        return $this->tile->getWealthFactor() +2;// TODO: Implement getWealthFactor() method.
    }
}
class PollutionDecorator extends TileDecorator
{
    public function getWealthFactor(): int
    {
        return $this->tile->getWealthFactor() -4;// TODO: Implement getWealthFactor() method.
    }
}

$tile=new PollutionDecorator(new DiamondDecorator(new Plains()));
print $tile->getWealthFactor();