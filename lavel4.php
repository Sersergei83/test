<?php
class Conf
{
    private \SimpleXMLElement $xml;
    private \SimpleXMLElement $lastmatch;
    public function __construct(private string $file)
    {
        if(!file_exists($file)){
            throw new \FileException("Файл '{$file}' не существует");
        }
        $xml = simplexml_load_file($file, null, LIBXML_NOERROR);
        if (!is_object($xml))
        {
            throw new XmlException(libxml_get_last_error());
        }
        $matces = $xml->xpath("/conf");
        if (!count($matces))
        {
            throw new ConfException("Не найден корневой єлемент");
        }
    }
    public function write():void
    {
        if(!is_writable($this->file)){
            throw new FileException("Нельзя писать в файл '{$this->file}'");
        }
        file_put_contents($this->file,$this->xml->asXML());
    }
    public function get(string $str): ? string
    {
        $matches = $this->xml->xpath("/conf/item[@name=\"$str\"]");
        if(count($matches))
        {
            $this->lastmatch = $matches[0];
            return (string)$matches[0];
        }

        return null;
    }
    public function set(string $key,string $value):void
    {
        if(! is_null($this->get($key)))
        {
            $this->lastmatch[0]=$value;
            return;
        }
        $conf = $this->xml->conf;
        $this->xml->addChild('item', $value)->addAttribute('name',$key);
    }
}
class XmlException extends \Exception
{
    public function __construct(private \LibXMLError $error)
    {
        $shortfile= basename($error->file);
        $msg = "[{$shortfile}, line {$error->line}," .
            "col {$error->column}] {$error->message}";
        $this->error=$error;
        parent:: __construct($msg, $error->code);
    }
    public function getLibXmlError(): \LibXMLError
    {
        return $this->error;
    }
}
class  FileException extends \Exception
{

}
class ConfException extends \Exception
{

}
class Runner
{
    public static function init()
    {
        try {
            $conf = new Conf(__DIR__."conf.broken.xml");
            print "user:" . $conf->get('user') . "\n";
            print "host:" . $conf->get('host') . "\n";
            $conf->set("pass","newpass");
            $conf->write();
        }
        catch (FileException $e)
        {
            print "Файл не существует";
        }
        catch (XmlException $e)
        {
            print $e;
            //print "Поврежденній xml";
        }
        catch (ConfException $e)
        {
            print "Не верный формат XML-файла";
        }
        catch (\Exception $e)
        {

        }
    }
}
//Runner::init();
class Runner1{
    public s
}