<?php
define('DBHOST', 'localhost');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');

$picpath = $_POST['PATH'] ;

try {
    session_start() ;
    if(isset($_SESSION['Username'])):
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $pdo->prepare("DELETE FROM petfavor WHERE petId IN (SELECT petId FROM petinfo WHERE img = :picpath)");
        $query->bindValue(':picpath',$picpath) ;
        $query->execute() ;

        $query = $pdo->prepare("DELETE FROM petinfo WHERE img = :picpath ;");
        $query->bindValue(':picpath',$picpath) ;
        $query->execute() ;


        echo "success" ;

        $pdo = null ;
    else:
        echo "notlogin" ;

    endif;

}
catch (PDOException $e) {
    die( $e -> getMessage() );
}


