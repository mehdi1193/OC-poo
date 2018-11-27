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
        if ($id < 0) {
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
        // Remplacer le constructeur par la méthode hydrate
    /*   $this->setId($donnees['id']);
       $this->setDegats($donnees['degats']);
       $this->setExperience($experience);
       $this->setNiveau($niveau);
       $this->setNom($nom);
       $this->setForcePerso($forcePerso);*/

        $this->hydrate($donnees);
    }
    public function hydrate(array $donnees){
        foreach($donnees as $cle => $valeur){
            $setter = 'set'.ucfirst($cle);
            if(method_exists($this, $setter)){
                $this->$setter($valeur);
            }
        }

        /* if(isset($donnees['id'])){
            $this->setId($donnees['id']);
        }
        if(isset($donnees['nom'])){
            $this->setNom($donnees['nom']);
        }
        if(isset($donnees['forcePerso'])){
            $this->setForcePerso($donnees['forcePerso']);
        }
        if(isset($donnees['degats'])){
            $this->setDegats($donnees['degats']);
        }
        if(isset($donnees['niveau'])){
            $this->setNiveau($donnees['niveau']);
        }
        if(isset($donnees['experience'])){
            $this->setExperience($donnees['experience']);
        } */
    }

}
//La classe Personnage Manager permet de gérer un personnage
class PersonnageManager{
    private $_bd;
    //les méthodes
    public function add(Personnage $perso){
         // Préparation de la requête d'insertion.
        // Assignation des valeurs pour le nom, la force, les dégâts, l'expérience et le niveau du personnage.
        // Exécution de la requête.
        $q = $this->_bd->prepare('INSERT INTO personnages(nom,forcePerso,niveau,experience,degats) VALUES (:nom,:forcePerso,:niveau,:experience,:degats)');
        $q->bindValue(':nom',$perso->nom());
        $q->bindValue(':forcePerso',$perso->forcePerso());
        $q->bindValue(':niveau',$perso->niveau());
        $q->bindvalue('experience',$perso->experience());
        $q->bindValue('degats',$perso->degats());

        $q->execute();
    }
    public function update(Personnage $perso){
        // Prépare une requête de type UPDATE.
        // Assignation des valeurs à la requête.
        // Exécution de la requête.
        $q = $this->_db->prepare('UPDATE personnages SET nom= :nom,forcePerso= :forcePerso,niveau = :niveau,experience = :experience,degats= :degats WHERE id = :id');
        $q->bindValue(':nom',$perso->nom());
        $q->bindValue(':forcePerso',$perso->forcePerso());
        $q->bindValue(':niveau',$perso->niveau());
        $q->bindvalue('experience',$perso->experience());
        $q->bindValue('degats',$perso->degats());
        $q->bindValue('id',$perso->id());

        $q->execute();


    }
    public function delete(Personnage $perso){
        // Exécute une requête de type DELETE.
        $this->_db->exec('DELETE FROM personnages WHERE id ='.$perso->id());

    }
    public function getList(){
        // Retourne la liste de tous les personnages.
            $persos = [];
        $q = $this->_db->query('SELECT id, nom, forcePerso, experience, niveau, degats FROM personnages ORDER BY nom');
        while($donnees = $q->fetch(PDO::FETCH_ASSOC)){
            $persos = new Personnage($donnees);
        }
        return $persos;

    }
    public function get($id){
        $id = (int) $id;
        // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
        $q = $this->_db->query('SELECT id, nom, forcePerso, niveau, experience, degats FROM personnages WHERE id='.$id);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
        return new Personnage($donnees);
    }
    public function setBd(PDO $db){
        $this->_bd=$db;
    }
    public function __construct($db){
        $this->setBd($db);

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

$perso = new Personnage([
    'nom' => 'Victor',
    'forcePerso' => 5,
    'degats' => 0,
    'niveau' => 1,
    'experience' => 0
  ]);
$db = new PDO('mysql:host=localhost;dbname=poo', 'root', '');
$manager = new PersonnageManager($db);
$manager->add($perso);
echo'succès';