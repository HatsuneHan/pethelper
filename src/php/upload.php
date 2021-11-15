<?php

define('DBHOST', 'localhost');
define('DBNAME', 'pethelper');
define('DBUSER', 'hatsune');
define('DBPASS', 'xbgd1993');
define('DBCONNSTRING','mysql:host=localhost;dbname=pethelper');

$city=$_POST['city'];
$org=$_POST['org'];
$breed=$_POST['breed'];
$name=$_POST['titletext'];
$description=$_POST['destext'];
$age=$_POST['agetext'];
$gender=$_POST['gendertext'];
echo $city;

function random($length, $chars = '0123456789')
{
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

function checkname($picpath)
{
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $pdo->prepare("SELECT img FROM petinfo WHERE img = :picpath ;");
    $query->bindValue(':picpath',$picpath) ;
    $query->execute() ;

    if($path = $query->fetchColumn())
    {
        $pdo = null ;
        return true ;
    }
    else
    {
        $pdo = null ;
        return false ;
    }


}


function insertpic($path,$name,$description,$city,$breed,$org,$age,$gender)
{
    session_start() ;
    $nowuser = $_SESSION['Username'] ;


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

    $queryuser = $pdo->prepare("SELECT UID FROM traveluser WHERE UserName = :user OR Email = :user ;");
    $queryuser->bindValue(':user',$nowuser) ;
    $queryuser->execute() ;
    $userid = $queryuser->fetchColumn() ;

    $querymax = $pdo->prepare("SELECT petId FROM petinfo ORDER BY petId DESC LIMIT 1");
    $querymax->bindValue(':user',$nowuser) ;
    $querymax->execute() ;
    $maxid = $querymax->fetchColumn() ;
    $petid = $maxid + 1 ;

    $insertsql = $pdo->prepare("INSERT INTO petinfo VALUES (:petid,:petname,:petage,:petgender,:breedid,:orgid,:cityid,:img,:description,0,:userid) ;");
    $insertsql->bindValue(':petid',$petid) ;
    $insertsql->bindValue(':petname',$name) ;
    $insertsql->bindValue(':petage',$age) ;
    $insertsql->bindValue(':petgender',$gender) ;
    $insertsql->bindValue(':breedid',$breediso) ;
    $insertsql->bindValue(':orgid',$orgiso) ;
    $insertsql->bindValue(':cityid',$cityiso) ;
    $insertsql->bindValue(':img',$path) ;
    $insertsql->bindValue(':description',$description) ;
    $insertsql->bindValue(':userid',$userid) ;
    $insertsql->execute();

    $test = $pdo->prepare("INSERT INTO petfavor VALUES(NULL,1,1);");
    $test->bindValue(':city',$city) ;
    $test->execute() ;
    $pdo = null ;

}


$localname = random(10, '1234567890abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');

if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/png"))
    )
{
    if(($_FILES["file"]["size"] < 83886080))
    {
        if ($_FILES["file"]["error"] > 0)
        {
            echo "Error: " . $_FILES["file"]["error"] . "<br />";
        }
        else
        {
//            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//            echo "Type: " . $_FILES["file"]["type"] . "<br />";
//            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//            echo "Stored in: " . $_FILES["file"]["tmp_name"] . "<br />" ;

            $arr = explode(".",$_FILES["file"]["name"]);
            $len = count($arr) ;

            $picpath = $localname . "." . $arr[$len-1] ;

            while(checkname($picpath))
            {
                $localname = random(10, '1234567890abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
                $picpath = $localname . "." . $arr[$len-1] ;
            }

            move_uploaded_file($_FILES["file"]["tmp_name"],
                "src/images/petimg/" . $picpath);

            insertpic($picpath,$name,$description,$city,$breed,$org,$age,$gender);

        }
    }
    else
    {
        echo "The picture should be no more than 10MB" ;
    }
}
else
{
    echo "Invalid file, just pictures are allowed";
}




?>