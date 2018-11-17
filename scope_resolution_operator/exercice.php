<?php
class Ami{
    
    private static $_compteur=0;
    
    public function __construct() {
        
        echo "l'attribut statique a été initialisé ".self::$_compteur++." fois !</br>";
    }
    
}

$ami1 = new Ami();
$ami2 = new Ami();
$ami3 = new Ami();

