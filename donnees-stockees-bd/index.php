<?php

class Personnage {

    private $_id;
    private $_nom;
    private $_forcePerso;
    private $_degats;
    private $_niveau;
    private $_experience;

//    Les getters

    public function id() {
        return $this->_id;
    }

    public function nom() {
        return $this->_nom;
    }

    public function forcePerso() {
        return $this->_forcePerso;
    }

    public function degats() {
        return $this->_degats;
    }

    public function niveau() {
        return $this->_niveau;
    }

    public function experience() {
        return $this->_experience;
    }

//  Les setters

    public function setId($id) {
        if (!is_int($id) || $id < 0) {
            trigger_error("L'id doit être un nombre positif", E_USER_WARNING);
        }
        $this->_id = $id;
    }

    public function setNom($nom) {
        if (!is_string($nom)) {
            trigger_error("Le nom doit être une chaîne de caractères", E_USER_WARNING);
        }
        $this->_nom = $nom;
    }

    public function setForcePerso($force) {
        if ($force < 0 || $force > 100) {
            trigger_error("La force doit être compris entre 0 et 100", E_USER_WARNING);
        }
        $this->_forcePerso = $force;
    }

    public function setDegats($degats) {
        if ($degats < 0 || $degats > 100) {
            trigger_error("La valeur des degats doit être compris entre 0 et 100", E_USER_WARNING);
        }
        $this->_degats = $degats;
    }

    public function setNiveau($niveau) {
        if ($niveau < 0 || $niveau > 100) {
            trigger_error("La valeur du niveau doit être compris entre 0 et 100 !", E_USER_WARNING);
        }
        $this->_niveau = $niveau;
    }

    public function setExperience($experience) {
        if ($experience < 0 || $experience > 100) {
            trigger_error("La valeur de l'experience doit être compris entre 0 et 100", E_USER_WARNING);
        }
        $this->_experience = $experience;
    }
    
    public function __construct($donnees) {
        $this->setId($donnees['id']);
        $this->setDegats($donnees['degats']);
//        $this->setExperience($experience);
//        $this->setNiveau($niveau);
//        $this->setNom($nom);
//        $this->setForcePerso($forcePerso);
    }

}

//Connexion à la base de données
try {
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : ' . $e->getMessage());
}

$request=$bdd->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnages');

while ($donnes = $request->fetch(PDO::FETCH_ASSOC)){
    $perso =new Personnage($donnes);
    echo $perso->id(),' mm : ',$perso->nom(),' a ',$perso->forcePerso(),' de force, ',$perso->degats(),' de dégâts, ',$perso->experience()
            ,'d\'expérience et il est au niveau ',$perso->niveau(),'</br>' ;
}
