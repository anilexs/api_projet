<?php
header("Access-Control-Allow-Origin:*");

// Inclure les fonctions :
require_once('./functions.php');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $url = $_SERVER['REQUEST_URI'];
    $url = trim($url, "\/");
    $url = explode("/", $url);
    $action = $url[0];
    if($action){
        findAll();
    }else{
        json_encode([
            "status" => 404,
            "message" => "grosse erreur"
        ]);
    }
} else {
    // On récupère les informations du "formulaire" de route.rest dans la variable data
    $data = json_decode(file_get_contents("php://input"), true); // Permet de récupérer le contenu du fichier dans $data

    if ($data["action"] == "produits") {
        // On appelle la fonction produits
        produits($data['nom'], $data['description'], $data['prix'], $data['categories_id']);
    } else {
        json_encode([
            "status" => 404,
            "message" => "Votre requête a échouée"
        ]);
    }
}