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

    $query = $pdo->prepare("SELECT COUNT(*) AS num FROM petfavor WHERE petId in (SELECT a.petId FROM (SELECT petId FROM petinfo WHERE img = :picpath )as a) ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $likenumber = $query->fetchColumn() ;
    echo $likenumber . "&" ;

    $query = $pdo->prepare("SELECT cityName FROM city WHERE cityId IN (SELECT a.cityId FROM (SELECT cityId FROM petinfo WHERE img = :picpath) as a) ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $City = $query->fetchColumn() ;
    echo $City . "&" ;

    $query = $pdo->prepare("SELECT orgName FROM org WHERE orgId IN (SELECT a.orgId FROM (SELECT orgId FROM petinfo WHERE img = :picpath) as a) ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $City = $query->fetchColumn() ;
    echo $City . "&" ;

    $query = $pdo->prepare("SELECT description FROM petinfo WHERE img = :picpath ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $Des = $query->fetchColumn() ;
    echo $Des . "&" ;

    $query = $pdo->prepare("SELECT breedName From breed WHERE breedId IN (SELECT a.breedId FROM (SELECT breedId FROM petinfo WHERE img = :picpath ) as a ) ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $breedName = $query->fetchColumn() ;
    echo $breedName . "&" ;

    $query = $pdo->prepare("SELECT petName FROM petinfo WHERE img = :picpath ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $tt = $query->fetchColumn() ;
    echo $tt . "&";

    $query = $pdo->prepare("SELECT gender FROM petinfo WHERE img = :picpath ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $gender = $query->fetchColumn() ;
    echo $gender . "&" ;

    $query = $pdo->prepare("SELECT age FROM petinfo WHERE img = :picpath ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    $age = $query->fetchColumn() ;
    echo $age . "&";

    $pdo = null ;

}
catch (PDOException $e) {
    die( $e -> getMessage() );
}

