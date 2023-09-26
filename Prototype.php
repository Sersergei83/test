<?php
class Plains
{

}
class Forest
{

}
class Sea
{
    public function __construct (private int $navigability)
    {

    }

}
class EarthPlains extends Plains
{

}
class EarthForest extends Forest
{

}
class EarthSea extends Sea
{

}
class MarsSea extends Sea
{

}
class MarsForest extends Forest
{

}
class MarsPlains extends Plains
{

}
class TerrainFactory
{
    public function __construct(private Sea $sea,
                                private Plains $plains,
                                private Forest $forest)
    {

    }
    public function getSea():Sea
    {
        return clone $this->sea;
    }
    public function getPlains():Plains
    {
        return clone $this->plains;
    }
    public function getForest():Forest
    {
        return clone $this->forest;
    }
}
class Contained
{

}
class Container
{
    public Contained $contained;
    public function __construct()
    {
        $this->contained=new Contained();
    }
    public function __clone()
    {
        $this->contained=clone $this->contained;
    }
}



$factory = new TerrainFactory(
    new EarthSea(),
    new EarthPlains(),
    new EarthForest()
);
print_r($factory->getSea());
print_r($factory->getPlains());
print_r($factory->getForest());
