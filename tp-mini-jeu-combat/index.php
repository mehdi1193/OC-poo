<?php
class Personnage{
    //les attributs
    private $_id;
    private $_nom;
    private $_degats;
    //Les constantes
    const CEST_MOI = 1;             //renvoyer une valeur signifiant que le personnage cible est le personnage qui attaque
    const PERSONNAGE_TUE = 2;       //renvoyer une valeur signifiant que le personnage a été tué 
    const PERSONNAGE_FRAPPE = 3;    //renvoyer une valeur signifiant que le personnage a été frappé

    //getters and setters
    public function id(){
        return $this->_id;
    }
    public function nom(){
        return $this->_nom;
    }
    public function degats(){
        return $this->_degats;
    }
    public function setId($id){
        $id = (int) $id;
        if ($id < 0) {
            trigger_error("L'id doit être un nombre positif", E_USER_WARNING);
        }else{            
            $this->_id=$id;
        }
    }
    public function setNom($nom){
        if (!is_string($nom)) {
            trigger_error("Le nom doit être une chaîne de caractères", E_USER_WARNING);
        }else{
            $this->_nom = $nom;
        }
    }
    public function setDegats($degats){
        $degats = (int) $degats;
        if ($degats < 0 || $degats > 100) {
            trigger_error("Les dégats doivent être un nombre positif", E_USER_WARNING);
        }else{
            $this->_degats = $degats;
        }
    }

    //les fonctionnalités du personnage
    public function frapper(Personnage $perso){
        //vérifier si on ne se frappe pas nous même
        if($this->_id == $perso->id()){
            return self::CEST_MOI;
        }else {
            $perso->recevoir();
        }

        //appeler la fonction recevoir de $perso 
    }
    public function recevoir(){
        //augmenter les degats de 5
        $this->_degats+=5;
        if($this->degats()>=100){
            return self::PERSONNAGE_TUE;
        }else{
            return self::PERSONNAGE_FRAPPE;
        }

        // si les degats sont à 100 ou plus , la méthode renverra une valeur signifiant que le personnage a été tué

        // sinon 
    }

    public function hydrate(array $donnees){
        foreach($donnees as $key => $value){
            $setter = 'set'.ucfirst($key);
            if(method_exists($this, $setter)){
                $this->$setter($value);
            }
        }
    }

    public function __construct(array $donnees){
        $this->hydrate($donnees);
    }

}