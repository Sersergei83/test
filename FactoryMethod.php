<?php
abstract class ApptEncoder
{
    abstract public function encode():string;
}
class BloggsApptEncoder extends ApptEncoder
{
    public function encode(): string
    {
        // TODO: Implement encode() method.
        return "Данные о встрече в формате BloggsCal \n";
    }
}
class MegaApptEncoder extends ApptEncoder
{
    public function encode(): string
    {
        // TODO: Implement encode() method.
        return "Данные о встрече в формате MegaCal \n";
    }
}
class CommManager
{
    public const BLOGGS = 1;
    public const MEGA =2;
    public function __construct(private int $mode)
    {

    }
    public function getApptEncoder():ApptEncoder
    {
        switch ($this->mode)
        {
            case (self::MEGA):
                return new MegaApptEncoder();
            default:
                return new BloggsApptEncoder();
        }

    }
    public function getHeaderText():string
    {
        switch ($this->mode)
        {
            case (self::MEGA):
                return "MegaCal header\n";
            default:
                return "BloggsCal header\n";
        }
    }
}


$man = new CommManager(CommManager::MEGA);
print (get_class($man->getApptEncoder())) . "\n";
$man = new CommManager(CommManager::BLOGGS);
print (get_class($man->getApptEncoder())) . "\n";