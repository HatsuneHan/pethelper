<?php
define('DBHOST', 'localhost');
define('DBNAME', 'travelwebsite');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');

$picpath = $_POST['PATH'] ;

try {

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $pdo->prepare("SELECT description FROM petinfo WHERE img = :picpath ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $Des = $query->fetchColumn() ;
    echo $Des . "&" ;

    $query = $pdo->prepare("SELECT petName FROM petinfo WHERE img = :picpath ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $tt = $query->fetchColumn() ;
    echo $tt . "&";

    $query = $pdo->prepare("SELECT cityName FROM city WHERE cityId IN (SELECT cityId FROM petinfo WHERE img = :picpath);");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $city = $query->fetchColumn() ;
    echo $city . "&";

    $query = $pdo->prepare("SELECT gender FROM petinfo WHERE img = :picpath;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $gender = $query->fetchColumn() ;
    echo $gender . "&";

    $query = $pdo->prepare("SELECT age FROM petinfo WHERE img = :picpath;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $age = $query->fetchColumn() ;
    echo $age . "&";

    $query = $pdo->prepare("SELECT breedName FROM breed WHERE breedId IN (SELECT breedId FROM petinfo WHERE img = :picpath);");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $breed = $query->fetchColumn() ;
    echo $breed . "&";

    $pdo = null ;

}
catch (PDOException $e) {
    die( $e -> getMessage() );
}

