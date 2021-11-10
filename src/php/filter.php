
<?php

$breed = $_POST['Breed'] ;
$city = $_POST['City'] ;

$org = $_POST['Org'] ;

define('DBHOST', 'localhost');
define('DBNAME', 'travelwebsite');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');


try{
    $resultarray = array() ;

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($breed == "Breed"):
        if($city == "City"):
            $query = $pdo->prepare("SELECT img FROM petinfo WHERE img IS NOT NULL;") ;
            $query->execute() ;

            while($row = $query -> fetch()):
                array_push($resultarray,$row['img']) ;
            endwhile;
        else:
            if($org == "Org"):
                $query = $pdo->prepare("SELECT img FROM petinfo WHERE cityId IN (SELECT cityId FROM city WHERE cityName = :cityname) AND img IS NOT NULL;") ;
                $query->bindValue(":cityname",$city) ;
                $query->execute() ;
//
                while($row = $query -> fetch()):
                    array_push($resultarray,$row['img']) ;
                endwhile;
            else:
                $query = $pdo->prepare("SELECT img FROM petinfo WHERE cityId IN (SELECT cityId FROM city WHERE cityName = :cityname) AND orgId IN (SELECT orgId FROM org WHERE orgName = :orgname) AND img IS NOT NULL;") ;
                $query->bindValue(":cityname",$city) ;
                $query->bindValue(":orgname",$org) ;
                $query->execute() ;
//
                while($row = $query -> fetch()):
                    array_push($resultarray,$row['img']) ;
                endwhile;
            endif;
        endif ;

    else:
        if($city == "City"):
            $query = $pdo->prepare("SELECT img FROM petinfo WHERE breedId IN (SELECT breedId from breed WHERE breedName = :breedname)  AND img IS NOT NULL") ;
            $query->bindValue(":breedname",$breed) ;
            $query->execute() ;

            while($row = $query -> fetch()):
                array_push($resultarray,$row['img']) ;
            endwhile;
        else:
            if($org == "Org"):
                $query = $pdo->prepare("SELECT img FROM petinfo WHERE breedId IN (SELECT breedId from breed WHERE breedName = :breedname) AND cityId IN (SELECT cityId FROM city WHERE cityName = :cityname) AND img IS NOT NULL ;") ;
                $query->bindValue(":breedname",$breed) ;
                $query->bindValue(":cityname",$city) ;
                $query->execute() ;

                while($row = $query -> fetch()):
                    array_push($resultarray,$row['img']) ;
                endwhile;
            else:
                $query = $pdo->prepare("SELECT img FROM petinfo WHERE breedId IN (SELECT breedId from breed WHERE breedName = :breedname) AND cityId IN (SELECT cityId FROM city WHERE cityName = :cityname) AND orgId IN (SELECT orgId FROM org WHERE orgName = :orgname) AND img IS NOT NULL ;") ;
                $query->bindValue(":breedname",$breed) ;
                $query->bindValue(":cityname",$city) ;
                $query->bindValue(":orgname",$org) ;
                $query->execute() ;

                while($row = $query -> fetch()):
                    array_push($resultarray,$row['img']) ;
                endwhile;
            endif;
        endif;

    endif;


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


// SELECT PATH FROM travelimage WHERE Content = :content ;
// SELECT PATH FROM travelimage WHERE CountryCodeISO IN (SELECT ISO FROM geocountries WHERE CountryName = :countryname) ;
// SELECT PATH FROM travelimage WHERE CityCode IN (SELECT GeoNameID FROM geocities WHERE AsciiName = :cityname) ;

//SELECT PATH FROM travelimage WHERE CountryCodeISO IN (SELECT ISO FROM geocountries WHERE CountryName = :countryname) AND CityCode IN (SELECT GeoNameID FROM geocities WHERE AsciiName = :cityname) ;