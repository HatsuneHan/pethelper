<?php
define('DBHOST', 'localhost');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');

$attr = $_POST['ATTR'] ;
$value = $_POST['VALUE'] ;

try{
    $patharray = array() ;
    $titlearray = array() ;
    $desarray = array() ;

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($attr == "title"):
        $query = $pdo->prepare("SELECT img,petName,description FROM petinfo WHERE petName LIKE :value LIMIT 20;") ;  ;
        $svalue = "%" . $value . "%" ;
        $query->bindValue(":value",$svalue) ;
        $query->execute() ;
        while($row = $query -> fetch()):
            array_push($patharray,$row['img']) ;
            array_push($titlearray,$row['petName']) ;
            array_push($desarray,$row['description']) ;
        endwhile;

    elseif($attr == "description"):
        $query = $pdo->prepare("SELECT img,petName,description FROM petinfo WHERE description LIKE :value LIMIT 20;") ;  ;
        $svalue = "%" . $value . "%" ;
        $query->bindValue(":value",$svalue) ;
        $query->execute() ;
        while($row = $query -> fetch()):
            array_push($patharray,$row['img']) ;
            array_push($titlearray,$row['petName']) ;
            array_push($desarray,$row['description']) ;
        endwhile;
    endif;

//    if(sizeof($patharray) == 0)
//        echo "none" ;

    $num = 0 ;
    foreach ($patharray as $number):
        if($num == 0)
            echo $number ;
        else
            echo "&" . $number ;
        $num = $num + 1 ;
    endforeach;

    echo "|||" ;
    $num = 0 ;
    foreach ($titlearray as $number):
        if($num == 0)
            echo $number ;
        else
            echo "&" . $number ;
        $num = $num + 1 ;
    endforeach;

    echo "|||" ;
    $num = 0 ;
    foreach ($desarray as $number):
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