<?php

/**
 * cette script gere :
 * - la classe Recipe qui représente une recette avec ses propriétés (id, name, description, photo) et son constructeur pour initialiser ces propriétés.
 * - le namespace "models" pour organiser le code et éviter les conflits de noms avec d'autres classes ou fonctions dans le projet.
 * - la classe Recipe peut être utilisée pour créer des objets représentant des recettes, ce qui facilite la manipulation et l'affichage des données de recette dans le projet.
 */
namespace models;
class Recipe{
    public $id;
    public $name;
    public $description;
    public $photo; 

    public function __construct($id,$name,$description,$photo){
        $this->id=$id;
        $this->name=$name;
        $this->description=$description;
        $this->photo=$photo;
    }
}
