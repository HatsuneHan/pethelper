<?php
define('DBHOST', 'localhost');
define('DBNAME', 'travelwebsite');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');

try{
    $hotbreed = array() ;
    $hotorg = array() ;
    $hotcity = array() ;

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT breedName FROM breed WHERE breedId IN (SELECT breedId FROM petinfo GROUP BY breedId ORDER BY Count(*) DESC) ;" ;
    $result = $pdo ->query($sql) ;

    while($row = $result -> fetch()):
        array_push($hotbreed,$row['breedName']) ;
    endwhile;

    $num = 0 ;
    foreach ($hotbreed as $number):
        if($num == 0)
            echo $number ;
        else
            echo "&" . $number ;
        $num = $num + 1 ;
    endforeach;

    echo "|||" ;

    $sql = "SELECT cityName FROM city WHERE cityId IN (SELECT cityId FROM petinfo GROUP BY cityId ORDER BY Count(*) DESC) ;" ;
    $result = $pdo ->query($sql) ;

    while($row = $result -> fetch()):
        array_push($hotcity,$row['cityName']) ;
    endwhile;

    $num = 0 ;
    foreach ($hotcity as $number):
        if($num == 0)
            echo $number ;
        else
            echo "&" . $number ;
        $num = $num + 1 ;
    endforeach;

    echo "|||" ;

    $sql = "SELECT orgName FROM org WHERE orgId IN (SELECT orgId FROM org GROUP BY orgId ORDER BY Count(*) DESC) ;" ;
    $result = $pdo ->query($sql) ;

    while($row = $result -> fetch()):
        array_push($hotorg,$row['orgName']) ;
    endwhile;

    $num = 0 ;
    foreach ($hotorg as $number):
        if($num == 0)
            echo $number ;
        else
            echo "&" . $number ;
        $num = $num + 1 ;
    endforeach;


    $pdo = null ;





}catch (PDOException $e){
    die( $e -> getMessage() );
}

//选出当前最热门的至少五个主题

// SELECT Content FROM travelimage GROUP BY Content ORDER BY Count(*) DESC ;

//选出当前最热门的五个国家

// SELECT CountryName FROM geocountries WHERE ISO IN (SELECT a.CountryCodeISO FROM(SELECT CountryCodeISO FROM travelimage WHERE CountryCodeISO IS NOT NULL GROUP BY CountryCodeISO ORDER BY COUNT(*) DESC LIMIT 6) As a ) ;


//选出当前最热门的五个城市

// SELECT AsciiName FROM geocities WHERE GeoNameID IN (SELECT a.CityCode FROM(SELECT CityCode FROM travelimage WHERE CityCode IS NOT NULL GROUP BY CityCode ORDER BY COUNT(*) DESC LIMIT 6) As a)
