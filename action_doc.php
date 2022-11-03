<?php
require_once("connection.php");
session_start();
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка ".mysqli_error($link));

if(isset($_GET['act']) && isset($_GET['id'])){ $id = $_GET['id'];
    if ($_GET['act'] == 1){
        $query = "UPDATE `doctors` SET `active`= 1 WHERE `id`=".$id;
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        header("location:staff_main.php");



        // $new_num = rand(10, 40);
        // $query = "INSERT INTO `cabinet`(`number`) VALUES ('" . $new_num . "')";
        // $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        // $result = mysqli_query($link, "SELECT MAX(id) FROM `cabinet`") or die("Ошибка " . mysqli_error($link));
        // $row = mysqli_fetch_assoc($result);
        // $id_new_cab = $row['MAX(id)'];
        // $query = "UPDATE `doctors` SET `active`= 1 ,`cabinet_id`=".$id_new_cab." WHERE `id`=".$id;
        // $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        // header("location:staff_main.php");
    } elseif($_GET['act'] == 0){
        $query = "UPDATE `doctors` SET `active`= 0 WHERE `id`=".$id;
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        header("location:staff_main.php");
    } elseif($_GET['act'] == 3){
        $query = "DELETE FROM `registration_coupon` WHERE `doctors_id` = ".$id;
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        $query = "DELETE FROM `doctors` WHERE `id` = ".$id;
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        header("location:staff_main.php");
    }
}
?>