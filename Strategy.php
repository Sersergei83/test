<?php
abstract class Question
{
    public function __construct(protected string $prompt, protected Marker $marker)
    {

    }
    public function mark(string $response):bool
    {
        return $this->marker->mark($response);
    }
}
class TextQuestion extends Question
{

}
class AVQuestion extends Question
{

}
abstract class Marker
{
    public function __construct(protected string $test)
    {

    }
    abstract public function mark (string $response):bool;


}
class MarkLogicMarker extends Marker
{
    private MarkParse $engine;
    public function __construct(string $test)
    {
        parent::__construct($test);
        $this->engine= new MarkParse($test);
    }
    public function mark(string $response): bool
    {
        return $this->engine->evaluate($response);
    }
}
class MatchMarker extends Marker
{
    public function mark(string $response):bool
    {
        return ($this->test==$response);
    }
}
class RegexpMarker extends Marker
{
    public function mark(string $response):bool
    {
        return (preg_match("$this->test",$response)===1);
    }
}

$markers=[
    new RegexpMarker("/пять/"),
   new MatchMarker("пять"),

];

foreach ($markers as $marker)
{
    print get_class($marker) ."\n";
    $question = new TextQuestion("Сколько лучей у пятиконечной звезді",$marker);
    foreach (["пять","четыре"] as $response)
    {
        print "Ответ: $response:";
        if ($question->mark($response))
        {
            print "Верно\n";
        }
        else
        {
            print "Неверно\n";
        }
    }
}