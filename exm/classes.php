<html>
<head>
    <title>ОБЪЕКТНО-ОРИЕНТИРОВАННОЕ ПРОГРАММИРОВАНИЕ</title>
</head>
<body>
<?php

abstract class Weapon
{
    /**
     * @var string $model
     * @var int $WeaponShop
     * @var int $shop
     */
    protected $model;
    protected $WeaponShop;
    protected $shop;

    /**
     * Weapon constructor.
     * @param $count - number of ammunition
     */
    function __construct($count)
    {
        try {
            if ($count <= $this->shop)
                $this->WeaponShop = $count;
            else
                throw new Exception('overlimit of maximum possible ammo capacity of $count for this model of weapon');
        } catch (Exception $x) {
            echo "Fatal error: Uncaught exeption 'Exeption' with message '",
            $x->getMessage(), "' in ...\n";
            exit (1);
        }
    }

    /**
     * @return string - Weapon`s model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return int - maximum number of ammunition
     */
    public function getMaxAmmo()
    {
        return $this->shop;
    }

    /**
     * subtracts ammunition from $WeaponShop (depending on the weapon`s model)
     * @return void
     */
    abstract public function fire();

    /**
     * @return int - current weapon`s number
     */
    public function getAmmo()
    {
        return $this->WeaponShop;
    }

    /**
     * reload weapon`s shop
     * @return void
     */
    public function reload()
    {
        $this->WeaponShop = $this->shop;
    }

    /**
     *Weapon destructor.
     */
    function __destruct()
    {
    }
}

class AK47 extends Weapon
{
    /**
     * AK47 constructor.
     * @param $count -  number of ammunition
     */
    function __construct($count)
    {
        $this->shop = 30;
        $this->model = "AK-47";
        parent::__construct($count);
        $this->WeaponShop = $count;
    }

    public function fire()
    {
        $i = 3;
        if ($this->WeaponShop > 0) {
            while ($i > 0 && $this->WeaponShop > 0) {
                $this->WeaponShop--;
                print "BANG! ";
                $i--;
            }
            while ($i > 0) {
                print "Click.";
                $i--;
            }
        } else
            print "Click.";
        echo "<br/>";
    }

    /**
     *AK47 destructor
     */
    function __destruct()
    {
        parent::__destruct();
    }
}

class BerettaM1934 extends Weapon
{
    /**
     * BerettaM1934 constructor.
     * @param $count - number of ammunition
     */
    function __construct($count)
    {
        $this->model = "Beretta M1934";
        $this->shop = 7;
        parent::__construct($count);

    }

    public function fire()
    {
        if ($this->WeaponShop > 0) {
            $this->WeaponShop--;
            print "BANG! ";
        } else
            print "Click.";
        echo "<br/>";
    }

    /**
     * BerettaM1934 destructor.
     */
    function __destruct()
    {
        parent::__destruct();
    }
}

?>
</body>
</html>
