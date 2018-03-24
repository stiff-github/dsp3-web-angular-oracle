<?php
/**
 * Created by PhpStorm.
 * User: kaa
 * Date: 02.08.2017
 * Time: 10:09
 */

//include database connection file
require_once 'db_config.php';


// verifying user from database using PDO
$stmt = $DBcon->prepare("SELECT user_email, user_password from user WHERE user_email='".$_POST['user_email']."' && user_password='".$_POST['user_password']."'");
$stmt->execute();
$row = $stmt->rowCount();
if ($row > 0){
    echo "correct";
} else{
    echo 'wrong';
}

?>