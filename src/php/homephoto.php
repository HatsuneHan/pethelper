<?php
define('DBHOST', 'localhost');
define('DBNAME', 'travelwebsite');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');

$method = $_POST['method'] ;

if($method == "hot"):
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //似乎有个看起来是版本问题的报错，但是实际可以通过在外层套一个SELECT解决，暂时不知道原因
        $sql = "SELECT img,petId,petName,description FROM petinfo ORDER BY RAND() LIMIT 8;" ;
//        SELECT PATH,ImageID,Title,Description FROM travelimage WHERE ImageID IN (SELECT a.ImageID FROM (SELECT ImageID FROM travelimagefavor GROUP BY ImageID ORDER BY COUNT(*) DESC LIMIT 8) AS a);
        $result = $pdo ->query($sql) ;
        $num = 0 ;
        $arraynum = 0 ;

        $picpath = array() ;
        $picindex = array() ;
        $pictitle = array() ;
        $picdescription = array() ;

        while($row = $result -> fetch()):
            array_push($picpath,$row['img']) ;
            array_push($picindex,$row['petId']) ;
            array_push($pictitle,$row['petName']) ;
            array_push($picdescription,$row['description']) ;
            $arraynum = $arraynum + 1 ;
        endwhile;


        for($i = $arraynum + 1 ; $i <= 8 ;$i = $i + 1):

            $sql = "SELECT img,petId,petName,description FROM petinfo ORDER BY RAND() LIMIT 1;" ;
            $result = $pdo ->query($sql) ;
            $row = $result -> fetch() ;

            if(in_array($row['petId'],$picindex) || $row['petId'] == 82):
                $i = $i - 1 ;
            else:
                array_push($picpath,$row['img']) ;
                array_push($picindex,$row['petId']) ;
                array_push($pictitle,$row['petName']) ;
                array_push($picdescription,$row['description']) ;
            endif;

        endfor;

        $num = 0 ;
        foreach ($picpath as $number):
            if($num == 0)
                echo $number ;
            else
                echo "&" . $number ;
            $num = $num + 1 ;
        endforeach;

        echo "|||" ;
        $num = 0 ;
        foreach ($pictitle as $number):
            if($num == 0)
                echo $number ;
            else
                echo "&" . $number ;
            $num = $num + 1 ;
        endforeach;

        echo "|||" ;
        $num = 0 ;
        foreach ($picdescription as $number):
            if($num == 0)
                echo $number ;
            else
                echo "&" . $number ;
            $num = $num + 1 ;
        endforeach;


//
//        $num = 0 ;
//        foreach ($picindex as $number):
//            if($num == 0)
//                echo $number ;
//            else
//                echo "&" . $number ;
//            $num = $num + 1 ;
//        endforeach;


        $pdo = null ;
    }
    catch (PDOException $e) {
        die( $e -> getMessage() );
    }
elseif($method == "refresh"):
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $picpath = array() ;
        $picindex = array() ;
        $pictitle = array() ;
        $picdescription = array() ;

        for($i = 1 ; $i <= 8 ;$i = $i + 1):

            $sql = "SELECT img,petId,petName,description FROM petinfo ORDER BY RAND() LIMIT 1;" ;
            $result = $pdo ->query($sql) ;
            $row = $result -> fetch() ;

            if(in_array($row['petId'],$picindex) || $row['petId'] == 82):
                $i = $i - 1 ;
            else:
                array_push($picpath,$row['img']) ;
                array_push($picindex,$row['petId']) ;
                array_push($pictitle,$row['petName']) ;
                array_push($picdescription,$row['description']) ;
            endif;

        endfor;

        $num = 0 ;
        foreach ($picpath as $number):
            if($num == 0)
                echo $number ;
            else
                echo "&" . $number ;
            $num = $num + 1 ;
        endforeach;

        echo "|||" ;
        $num = 0 ;
        foreach ($pictitle as $number):
            if($num == 0)
                echo $number ;
            else
                echo "&" . $number ;
            $num = $num + 1 ;
        endforeach;

        echo "|||" ;
        $num = 0 ;
        foreach ($picdescription as $number):
            if($num == 0)
                echo $number ;
            else
                echo "&" . $number ;
            $num = $num + 1 ;
        endforeach;

//        echo "|||" ;
//
//        $num = 0 ;
//        foreach ($picindex as $number):
//            if($num == 0)
//                echo $number ;
//            else
//                echo "&" . $number ;
//            $num = $num + 1 ;
//        endforeach;


        $pdo = null ;
    }
    catch (PDOException $e) {
        die( $e -> getMessage() );
    }

endif;




