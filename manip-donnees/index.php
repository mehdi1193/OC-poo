<?php
class Personnage
{
    //Les attributs
    private $_id;
    private $_nom;
    private $_forcePerso;
    private $_degats;
    private $_niveau;
    private $_experience;
    //Les getters
    public function id(){
        return $this->_id;
    }
    public function nom(){
        return $this->_nom;
    }
    public function forcePerso(){
        return $this->_forcePerso;
    }
    public function degats(){
        return $this->_degats;
    }
    public function niveau(){
        return $this->_niveau;
    }
    public function experience(){
        return $this->_experience;
    }

    //Les setters
    public function setId($id){
        $id = (int)$id;
        if($id>0){
            $this->_id=$id;
        }
    }
    public function setNom($nom){
        if(is_string($nom)){
            $this->_nom=$nom;
        }
    }
    public function setForce($force){
        $force=(int)$force;
        if($force >0 && $force<=100){
            $this->_force = $force;
        }
    }
    public function setDegats($degats){
        $degats = (int)$degats;
        if($degats >=0 && $degats<=100){
            $this->_degats = $degats;
        }
    }

    public function setNiveau($niveau){
        $niveau = (int)$niveau;
        if($niveau >=1 && $niveau<=100){
            $this->_niveau = $niveau;
        } 
    }

    public function setExperience($experience){
        $experience = (int)$experience;
        if($experience >=1 && $experience<=100){
            $this->_experience = $experience;
        }
    }

    public function __construct(array $donnees){
        $this->setId($donnees['id']);
        $this->setNom($donnees['nom']);
        $this->setForce($donnees['forcePerso']);        
        $this->setDegats($donnees['degats']);
        $this->setNiveau($donnees['niveau']);
        $this->setExperience($donnees['experience']);
    }

    public function hydrate(array $donnees){
        //hydrater un objet revient à assigner des valeurs à ses attributs
        foreach($donnees as $key => $value){
            $method='set'.ucfirst($key);
            if(isset($donnees[$key])){                
                $this->$method($value);
            }
        }
    }

}


// On admet que $db est un objet PDO.
try {
    $db = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', '');
    echo 'Sir, the database is open</br>';
} catch (Exception $exc) {
    die("Problème d'accès à la base de données".$exc->getMessage());
}

$request = $db->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnages');
//print_r($request);    
while ($donnees = $request->fetch(PDO::FETCH_ASSOC)) // Chaque entrée sera récupérée et placée dans un array.
{
  // On passe les données (stockées dans un tableau) concernant le personnage au constructeur de la classe.
  // On admet que le constructeur de la classe appelle chaque setter pour assigner les valeurs qu'on lui a données aux attributs correspondants.
  $perso = new Personnage($donnees);
        
  echo $perso->nom(), ' a ', $perso->forcePerso(), ' de force, ', $perso->degats(), ' de dégâts, ', $perso->experience(), ' d\'expérience et est au niveau ', $perso->niveau().'</br>';
}