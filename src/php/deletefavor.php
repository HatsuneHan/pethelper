<?php
define('DBHOST', 'localhost');
define('DBNAME', 'travelwebsite');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');

$picpath = $_POST['PATH'] ;

try {
    session_start() ;
    if(isset($_SESSION['Username'])):
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $pdo->prepare("SELECT favorId FROM petfavor WHERE userId IN(SELECT a.UID FROM(SELECT UID FROM traveluser WHERE UserName = :username OR Email = :username)as a) AND petId IN(SELECT b.petId FROM(SELECT petId FROM petinfo WHERE img = :picpath)as b)");
        $query->bindValue(':picpath',$picpath) ;
        $query->bindValue(':username',$_SESSION['Username']) ;
        $query->execute() ;

        $result = $query->fetchColumn() ;

        if($result):
            $q = $pdo ->prepare("DELETE FROM petfavor WHERE favorId = :fid") ;
            $q ->bindValue(":fid",$result) ;
            $q->execute() ;
            echo "success"  ;
        else:
            echo "fail" ;
        endif ;


        $pdo = null ;
    else:
        echo "notlogin" ;

    endif;

}
catch (PDOException $e) {
    die( $e -> getMessage() );
}


