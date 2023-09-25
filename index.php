<?php
abstract class ShopProductWriter
{
    protected array $products = [];
    public function addProduct(ShopProduct $shopProduct): void
    {
        $this->products[] =$shopProduct;
    }

    /**
     * @return array
     */
    abstract public function write():void;

}

class ShopProduct implements Chargeable
{
    private int | float $discont = 0;
    use PriceUtilities;
    use IdentityTrait;
    public function __construct(protected string $title,
                                private string $producerFirstName,
                                protected string $producerMainName,
                                protected int | float $price)
    {
    }

    /**
     * @return string
     */
    public function getProducerFirstName() : string
    {
        return $this->producerFirstName;
    }

    /**
     * @return string
     */
    public function getProducerMainName(): string
    {
        return $this->producerMainName;
    }
    public function setDiscount(int | float $num): void
    {
        $this->discont = $num;
    }
    public function getDiscount(): int
    {
        return $this->discont;
    }
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return float|int
     */
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getProducer(): string
    {
        return  $this->producerFirstName . " " .$this->producerMainName;
    }
    public function  getSummaryLine():string
    {
        $base = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        return $base;
    }

}

class CDProduct extends ShopProduct
{
    public function  __construct(string $title, string $FirstName, string $MainName, float|int $price, private  int $playLength)
    {
        parent:: __construct($title, $FirstName,$MainName,$price);
    }

    /**
     * @return int
     */
    public function getPlayLength(): int
    {
        return $this->playLength;
    }
    public function getSummaryLine(): string
    {
        $base = "{$this->title} ( {$this->producerMainName},";
        $base .= ": Время звучания - {$this->playLength}";
        return $base;
    }
}
class BookProduct extends ShopProduct
{
    public function __construct(string $title, string $FirstName, string $MainName, float|int $price, private  int $numPages)
    {
        parent:: __construct($title,$FirstName,$MainName,$price);
    }

    /**
     * @return int
     */
    public function getNumberOfPages(): int
    {
        return $this->numPages;
    }
    public function getSummaryLine(): string
    {
        $base = parent::getSummaryLine();
        $base .= ": - {$this->numPages} стр. ";
        return $base;
    }

    /**
     * @return float|int
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
class XmlProductWriter extends ShopProductWriter
{
    public function write(): void
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement("Товары");
        foreach ($this->products as $shopProduct)
        {
            $writer->startElement("Товар");
            $writer->writeAttribute("Наименование",$shopProduct->getTitle());
            $writer->startElement("Резюме");
            $writer->text($shopProduct->getSummaryLine());
            $writer->endElement();
            $writer->endElement();
        }
        $writer->endElement();
        $writer->endDocument();
        print $writer->flush();
    }

}
class TextProductWriter extends ShopProductWriter
{
    public function write(): void
    {
       $str="ТОВАРЫ:\n";
       foreach ($this->products as $shopProduct)
       {
           $str .=$shopProduct->getSummaryLine(). "\n";
       }
       print $str;
    }
}

interface Chargeable
{
    public function getPrice():float;
}
class Shipping implements Chargeable
{
    public function __construct(private float $price)
    {

    }
    public function getPrice():float
    {
        return $this->price;
    }
}
abstract class Service
{

}
class UtilityService extends Service
{
    use PriceUtilities;
}
trait PriceUtilities
{
    private int $taxrate=20;
    public function calculateTax (float $price): float
    {
        return (($this->taxrate/100)*$price);
    }
}
trait IdentityTrait{
    public function generateId(): string
    {
        return uniqid();
    }
}
$p = new ShopProduct("Товар","Лев","Толстой",20);
print $p->calculateTax(900) . "\n";
print $p->generateId() ."\n";
$u = new UtilityService();
print $u->calculateTax(100) . "\n";