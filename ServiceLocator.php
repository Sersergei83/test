<?php
include_once "FactoryMethod.php";
class Settings
{
    public static string $COMMSTYPE='Mega';
}
class AppConfig
{
    private static ? AppConfig $instance =null;
    private CommManager $commsManager;
    private function __construct()
    {
        $this->init();
    }
    private function init():void
    {
        switch (Settings::$COMMSTYPE)
        {
            case 'Mega':
                $this->commsManager=new MegaCommsManager();
                break;
            default:
                $this->commsManager=new BloggsCommsManager();
        }
    }
    public static function getInstance():AppConfig
    {
        if (is_null(self::$instance))
        {
            self::$instance=new self();
        }
        return self::$instance;
    }
    public function getCommsManager():CommManager
    {
        return $this->commsManager;
    }
}
$commsMgr=AppConfig::getInstance()->getCommsManager();
print $commsMgr->getApptEncoder()->encode();