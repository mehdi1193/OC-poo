<?php
class Personnage{
    //Déclaration des attributs (caractéristiques du personnage)
    private $_id;
    private $_nom;
    private $_forcePerso;
    private $_degats;
    private $_experience;
    private $_niveau;
    
    //Les getters
    public function getId() {
        return $this->_id;        
    }
    public function getNom() {
        return $this->_nom;
    }
    public function getForcePerso() {
        return $this->_forcePerso;
    }
    public function getDegats() {
        return $this->_degats;
    }
    public function getExperience() {
        return $this->_experience;
    }
    public function getNiveau() {
        return $this->_niveau;
    }
    
//Les setters
    public function setId($id) {
        $id = (int)$id;
        if($id>0){
            $this->_id=$id;
        }
    }
    public function setNom($nom) {
        $nom = (string)$nom;
        $this->_nom=$nom;
    }
    public function setForce($force) {
        $force = (int)$force;
        if($force >0 && $force<100){
            $this->_forcePerso=$force;
        }
    }
    public function setDegats($degats) {
        $degats = (int)$degats;
        if($degats >0 && $degats<100){
            $this->_degats =$degats;
        }
    }
    public function setNiveau($niveau) {
        $niveau = (int)$niveau;
        if($niveau >0 && $niveau<100){
            $this->_niveau=$niveau;
        }
    }
    public function setExperience($experience) {
        $experience = (int)$experience;
        if($experience >0 && $experience<100){
            $this->_experience=$experience;
        }
    }
    
    public function __construct($donnees) {
        $this->setId($donnees['id']);
        $this->setDegats($donnees['degats']);
        $this->setExperience($donnees['experience']);
        $this->setNiveau($donnees['niveau']);
        $this->setForce($donnees['forcePerso']);
        $this->setNom($donnees['nom']);
    }
    
    public function hydrater(array $donnees) {
        
    }
    
}
// On admet que $db est un objet PDO.

//Connexion à la base de données
try {
    // On se connecte à MySQL
    $db = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : ' . $e->getMessage());
}

$request = $db->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnages');
    
while ($donnees = $request->fetch(PDO::FETCH_ASSOC)) // Chaque entrée sera récupérée et placée dans un array.
{
  // On passe les données (stockées dans un tableau) concernant le personnage au constructeur de la classe.
  // On admet que le constructeur de la classe appelle chaque setter pour assigner les valeurs qu'on lui a données aux attributs correspondants.
  $perso = new Personnage($donnees);
        
  echo $perso->getNom(), ' a ', $perso->getForcePerso(), ' de force, ', $perso->getDegats(), ' de dégâts, ', $perso->getExperience(), ' d\'expérience et est au niveau ', $perso->getNiveau().'</br>';
}