<?php
    require_once("connection.php");
    session_start();
    $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка ".mysqli_error($link));
    $coupon_id = $_GET['id'];
    echo $coupon_id;
    $query = "DELETE FROM `registration_coupon` WHERE `id` =".$coupon_id;
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

    if($_GET['k'] == 1){
        header("location:service_doc.php");
    } else { header("location:service.php");    }

?>