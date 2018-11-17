<?php
//Création d'une classe
class Personnage{
    private $_force;
    private $_localisation;
    private $_experience=3;
    private $_degats;
    
    public function deplacer(){
        
    }
    
    public function frapper(){
        echo 'Je frappe fort';
    }
    
    public function gagnerExperience(){
        echo $this->_experience +=3;
    }
    
    public function afficherExperience(){
        echo $this->_experience;
    }
    
    
}
$perso = new Personnage;
$perso->frapper();
//$perso->_force=2;

$perso->afficherExperience();
$perso->gagnerExperience();
$perso->afficherExperience();
