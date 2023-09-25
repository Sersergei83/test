<?php
class Product
{
    public function __construct(public string $name,
                                public float $price)
    {

    }

}
class ProcessSale
{
    private array $callbacks;
    public function registerCallback(callable $callback): void
    {
        $this->callbacks[] = $callback;
    }
    public function sale(Product $product):void
    {
        print "{$product->name}:обробатываеться \n";
        foreach ($this->callbacks as $callback)
        {
            call_user_func($callback,$product);
        }
    }
}
class Mailer
{
    public function doMail(Product $product):void
    {
        print " Отправляеться ({$product->name})\n";
    }
}
class Totalizer
{
    public static function warnAmout():callable
    {
        return function (Product $product)
        {
            if ($product->price>5)
            {
                print "Достигнута вісокая цена: {$product->price} \n";
            }
        };
    }
}
class Totalizer2
{
    public static function warnAmount($amt):callable
    {
        $count =0;
        return function ($product) use ($amt, &$count)
        {
            $count +=$product->price;
            print "summa: $count \n";
            if ($count>$amt)
            {
                print "limmit : {$count}\n";
            }
        };
    }
}
class Totalizer3
{
    private float $count=0;
    private float $amt=0;
    public function warnAmount(int $amt):callable
    {
        $this->amt = $amt;
        return \Closure::fromCallable([$this,"processPrice"]);
    }
    private function processPrice (Product $product):void
    {
        $this->count +=$product->price;
        print "Summa: {$this->count}\n";
        if ($this->count>$this->amt)
        {
            print "Limmit2: {$this->count}\n";
        }
    }
}
$logger = fn($product) =>print  "Запись ({$product->name}) \n";
$processor =new ProcessSale();
$processor3=new Totalizer3();
$processor->registerCallback($logger);
$processor->registerCallback([new Mailer(),"doMail"]);
$processor->registerCallback(Totalizer::warnAmout());
$processor->registerCallback(Totalizer2::warnAmount(8));
$processor->registerCallback($processor3->warnAmount(8));
$processor->sale(new Product("Туфли", 4));
print "\n";
$processor->sale(new Product("Кофе", 6));
