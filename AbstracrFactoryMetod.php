<?php
interface Encoder
{
    public function encode():string;
}
abstract class CommsManager
{
    public const APPT = 1;
    public const TTD = 2;
    public const CONTACT = 3;
    abstract public function getHeaderText():string;
    abstract public function make(int $flag_int):Encoder;
    abstract public function getFooterText():string;
}

class BloggsCommsManager extends CommsManager
{
    public function getHeaderText():string
    {
        return "ерхний колонтитул BloggsCal\n";
    }
    public function make(int $flag_int): Encoder
    {
        // TODO: Implement make() method.
        switch ($flag_int)
        {
            case self::APPT:
                return new BloggsApptEncoder();
            case self::CONTACT:
                return new BloggsContactEncoder();
            case self::TTD:
                return new BloggsTtdEncoder();
        }
    }
    public function getFooterText():string
    {
        return "Нижний колонтитул BloggsCal\n";
    }
}
c
