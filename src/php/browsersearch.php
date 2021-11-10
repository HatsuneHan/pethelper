<?php

$attr = $_POST['ATTR'] ;
$value = $_POST['VALUE'] ;

define('DBHOST', 'localhost');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');


if($attr == "ALL"):
    try{
        $resultarray = array() ;

        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $pdo->prepare("SELECT img FROM petinfo WHERE img IS NOT NULL") ;
        $query->execute() ;

        while($row = $query -> fetch()):
            array_push($resultarray,$row['img']) ;
        endwhile;

        $num = 0 ;
        foreach ($resultarray as $number):
            if($num == 0)
                echo $number ;
            else
                echo "&" . $number ;
            $num = $num + 1 ;
        endforeach;

//    echo  sizeof($resultarray) ;
        $pdo = null ;

    }catch (PDOException $e){
        die( $e -> getMessage() );
    }
else:
    try{
        $resultarray = array() ;


        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($attr == "Breed"):

            $query = $pdo->prepare("SELECT img FROM petinfo WHERE breedId IN (SELECT breedId FROM breed WHERE breedName = :value) AND img IS NOT NULL") ;
            $query->bindValue(":value",$value) ;
            $query->execute() ;

            while($row = $query -> fetch()):
                array_push($resultarray,$row['img']) ;
            endwhile;


        elseif($attr == "Org"):

            $query = $pdo->prepare("SELECT img FROM petinfo WHERE orgId IN (SELECT orgId FROM org WHERE orgName = :value) AND img IS NOT NULL") ;
            $query->bindValue(":value",$value) ;
            $query->execute() ;

            while($row = $query -> fetch()):
                array_push($resultarray,$row['img']) ;
            endwhile;



        elseif($attr == "City"):

            $query = $pdo->prepare("SELECT img FROM petinfo WHERE cityId IN (SELECT cityId FROM city WHERE cityName = :value) AND img IS NOT NULL") ;
            $query->bindValue(":value",$value) ;
            $query->execute() ;

            while($row = $query -> fetch()):
                array_push($resultarray,$row['img']) ;
            endwhile;


         elseif($attr == "Title"):
             $query = $pdo->prepare("SELECT img FROM petinfo WHERE petName LIKE :value") ;
             $title = "%" . $value . "%" ;
             $query->bindValue(":value",$title) ;
             $query->execute() ;

             while($row = $query -> fetch()):
                 array_push($resultarray,$row['img']) ;
             endwhile;

        endif ;

        $num = 0 ;
        foreach ($resultarray as $number):
            if($num == 0)
                echo $number ;
            else
                echo "&" . $number ;
            $num = $num + 1 ;
        endforeach;

//    echo  sizeof($resultarray) ;
        $pdo = null ;

    }catch (PDOException $e){
        die( $e -> getMessage() );
    }
endif;


// SELECT PATH FROM travelimage WHERE CityCode IN (SELECT GeoNameID FROM geocities WHERE AsciiName = :value)
// SELECT PATH FROM travelimage WHERE CountryCodeISO IN (SELECT ISO FROM geocountries WHERE CountryName = :value)

// SELECT PATH FROM travelimage WHERE Title LIKE '%children%' ;
