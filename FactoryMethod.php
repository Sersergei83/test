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
abstract class CommManager
{
    abstract public function getHeaderText():string;
    abstract public function getApptEncoder():ApptEncoder;
    abstract public function getFooterText():string;
}
class BloggsCommsManager extends CommManager
{
    public function getHeaderText():string
    {
        return "ерхний колонтитул BloggsCal\n";
    }
    public function getApptEncoder(): ApptEncoder
    {
        return new BloggsApptEncoder();
    }
    public function getFooterText():string
    {
        return "Нижний колонтитул BloggsCal\n";
    }
}


$mgr = new BloggsCommsManager();
print $mgr->getHeaderText();
print $mgr->getApptEncoder()->encode();
print $mgr->getFooterText();