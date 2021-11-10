
<?php

$attr = $_POST['ATTR'] ;
if(isset($_POST['NOW']))
    $nowcity = $_POST['NOW'] ;

define('DBHOST', 'localhost');
define('DBNAME', 'travelwebsite');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');


try{
    $resultarray = array() ;

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($attr == "Breed"):
        $query = $pdo->prepare("SELECT DISTINCT breedName FROM breed ORDER BY breedName ;") ;
        $query->execute() ;

        while($row = $query -> fetch()):
            array_push($resultarray,$row['breedName']) ;
        endwhile;

        //"SELECT DISTINCT CountryName FROM geocountries WHERE ISO IN (SELECT a.CountryCodeISO FROM(SELECT CountryCodeISO FROM travelimage WHERE CountryCodeISO IS NOT NULL) As a ) ORDER BY CountryName;"
    elseif($attr == "City"):
        $query = $pdo->prepare("SELECT DISTINCT cityName FROM city ORDER BY cityName;") ;
        $query->execute() ;

        while($row = $query -> fetch()):
            array_push($resultarray,$row['cityName']) ;
        endwhile;
    elseif($attr == "Org"):
        $query = $pdo->prepare("SELECT DISTINCT orgName FROM org WHERE cityId IN (SELECT cityId FROM city where cityName = :nowcity);") ;
        $query->bindValue(":nowcity",$nowcity);
        $query->execute() ;

        while($row = $query -> fetch()):
            array_push($resultarray,$row['orgName']) ;
        endwhile;
    endif;
//
    $pdo = null ;


    $num = 0 ;
    foreach ($resultarray as $number):
        if($num == 0)
            echo $number ;
        else
            echo "&" . $number ;
        $num = $num + 1 ;
    endforeach;

//    echo  sizeof($resultarray) ;


}catch (PDOException $e){
    die( $e -> getMessage() );
}


//
