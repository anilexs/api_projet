<?php

function dbConnect(){
    $conn = null;

    try{
        $conn = new PDO("mysql:host=localhost;dbname=bdd_api", "root", "");
    }catch(PDOException $e){
        $conn = $e->getMessage();
    }
    return $conn;
}

function produits($nom, $description, $prix, $categorie_id){
    // connexion base de données :
    $db = dbConnect();

    // préparer la requéte
    $request = $db->prepare("INSERT INTO produits (nom, description, prix, categories_id) VALUES (?,?,?,?)");
    
    // Executer la requéte :
    try{
        $request->execute([$nom, $description, $prix, $categorie_id]);
        echo json_encode([
            "status" => 200,
            "message" => "Produit envoyé avec succés"
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
        echo json_encode([
            "status" => 500,
            "message" => "Produit non envoyé, réessaye merci !"
        ]);
    }
}

function findAll(){
    $db = dbConnect();

    // préparer la requéte
    $request = $db->prepare("SELECT * FROM produits");
    try{
        $request->execute();
        $produits = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            "status" => 200,
            "message" => "Voici la liste des produits disponibles",
            "data" => $produits
        ]);
    }catch(PDOException $e){
        echo json_encode([
            "status" => 404,
            "message" => "aucun produit a ete trouver",
            "error" => $e
        ]);
    }
}