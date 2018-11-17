<?php
class Personnage
{
  private $_degats = 0; // Les dégâts du personnage.
  private $_experience = 0; // L'expérience du personnage.
  private $_force = 20; // La force du personnage (plus elle est grande, plus l'attaque est puissante).
        
  public function gagnerExperience()
  {
    // On ajoute 1 à notre attribut $_experience.
    $this->_experience = $this->_experience + 1;
  }
  
  public function frapper(Personnage $a){
       $a->_degats += $this->_force;
  }
  public function afficherDegats(){
      echo $this->_degats.'</br>';
  }
  
  public function experience(){
      return $this->_experience;
  }
  
  public function setExperience($experience){
      if(!is_int($experience)){
          trigger_error("L'experience du personnage doit être un entier !",E_USER_WARNING);
      }
      $this->_experience=$experience;
  }
}
$perso1 = new Personnage;
$perso2 = new Personnage;
//$perso1->frapper($perso2);
//
//$perso1->afficherDegats();
//$perso2->afficherDegats();
$perso2->frapper($perso1);
$perso1->gagnerExperience();
$perso1->frapper($perso2);
$perso2->gagnerExperience();
$a=50;
//$a->frapper();
$perso2->setExperience(2);