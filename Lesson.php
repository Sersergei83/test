<?php
//Патерн Стратегия
abstract class CostStrategy
{
    abstract public function cost(Lesson $lesson):int;
    abstract public function chargeType(): string;
}
class TimeCostStrategy extends CostStrategy
{
    public function cost(Lesson $lesson): int
    {
        return  ($lesson->getDuration()*5);// TODO: Implement cost() method.
    }
    public function chargeType(): string
    {
      return "Почасовая оплата";  // TODO: Implement chargeType() method.
    }
}
class FixedCostStrategy extends CostStrategy
{
    public function cost(Lesson $lesson): int
    {
        return 30;// TODO: Implement cost() method.
    }
    public function chargeType(): string
    {
        return "Фиксированая ставка";  // TODO: Implement chargeType() method.
    }
}
abstract class Lesson
{

    public function __construct(protected  int $duration,
                                private CostStrategy $costStrategy)
    {

    }
    public function  cost():int
    {
        return $this->costStrategy->cost($this);

    }
    public function chargeType():string
    {
        return $this->costStrategy->chargeType();
    }
    public function getDuration():int
    {
        return $this->duration;
    }
}
class Lecture extends Lesson{

}
class Seminar extends Lesson{

}


$lessons[] = new Seminar(4,new TimeCostStrategy());
$lessons[]= new Lecture(4,new FixedCostStrategy());

foreach ($lessons as $lesson)
{
    print "Оплата за занятие {$lesson->cost()}.";
    print "Тип оплаты: {$lesson->chargeType()}\n";
}