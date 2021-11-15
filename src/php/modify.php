<?php
define('DBHOST', 'localhost');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');

$imgpath=$_POST['img'];
$city=$_POST['city'];
$org=$_POST['org'];
$breed=$_POST['breed'];
$name=$_POST['petname'];
$description=$_POST['description'];
$age=$_POST['agetext'];
$gender=$_POST['gendertext'];

try{
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($city == "城市")
    {
        $cityiso = null ;
    }
    else
    {
        $querycity = $pdo->prepare("SELECT cityId FROM city WHERE cityName = :city ;");
        $querycity->bindValue(':city',$city) ;
        $querycity->execute() ;
        $cityiso = $querycity->fetchColumn() ;
    }


    if($org == "机构")
    {
        $orgiso = null ;
    }
    else
    {
        $queryorg = $pdo->prepare("SELECT orgId FROM org WHERE orgName = :org ;");
        $queryorg->bindValue(':org',$org) ;
        $queryorg->execute() ;
        $orgiso = $queryorg->fetchColumn() ;
    }

    if($breed == "品种")
    {
        $breediso = null ;
    }
    else
    {
        $querybreed = $pdo->prepare("SELECT breedId FROM breed WHERE breedName = :breed ;");
        $querybreed->bindValue(':breed',$breed) ;
        $querybreed->execute() ;
        $breediso = $querybreed->fetchColumn() ;
    }

    //

    $insertsql = $pdo->prepare("UPDATE petinfo SET petName = :petname, description = :description, cityId = :cityid, orgId = :orgid, breedId = :breedid, gender=:petgender, age=:petage WHERE img = :img");
    $insertsql->bindValue(':petname',$name) ;
    $insertsql->bindValue(':petage',$age) ;
    $insertsql->bindValue(':petgender',$gender) ;
    $insertsql->bindValue(':breedid',$breediso) ;
    $insertsql->bindValue(':orgid',$orgiso) ;
    $insertsql->bindValue(':cityid',$cityiso) ;
    $insertsql->bindValue(':img',$imgpath) ;
    $insertsql->bindValue(':description',$description) ;
    $insertsql->execute() ;

    $pdo = null ;

}
catch (PDOException $e) {
    die( $e -> getMessage() );
}