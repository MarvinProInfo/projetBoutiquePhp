<?php

//Lancement de la session
session_start();

$pdo = new PDO('mysql:host=localhost; dbname=boutique',
        'root', 
        '',
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        )

        );

//Constante quu se définit à la fin du projet
define('BASE',"/PROJET_BOUTIQUE/");

//fonction de debug
function debug($var){
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}

function traitement($data){
    foreach($data as$marqueur => $valeur){
        $data[$marqueur] = htmlspecialchars($valeur);
        //on transforme les chevrons en entité html qui neutralise les balises script ou style eventuellement infectées
        //On parle de neutraliser les failles xss et css
    }
    return $data;
}