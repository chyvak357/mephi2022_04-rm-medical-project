<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Обслуживание</title>

    <link rel="stylesheet" type="text/css" href="styles.css">



</head>

<body>
    <?php require_once("connection.php");
session_start();
?>


    <div id="header">
        <h1>Поликлиника №100500</h1>
        <div id="nav">
            <ul>
                <li><a href="contacts.php">Контакты</a></li>
                <?php if(!isset($_SESSION["user_rang"])):?>
                <li><a href="reg_doc.php">Регистрация</a></li>
                <?php elseif(isset($_SESSION['user_rang'])): ?>
                <li><a href="service_doc.php">Профиль</a></li>
                <li><a href="logout.php">Выйти</a></li>
                <?php endif; ?>
                <li><a href="index.php">Главная</a></li>

            </ul>
        </div>
    </div>





    <div class="wrapper">



        <!--    Боковая панель пользователя  -->
        <div id="sidebar1" class="aside">


            <?php

        $link = mysqli_connect($host, $user, $password, $database)
        or die("Ошибка ".mysqli_error($link));

        $query_enc = "SET NAMES utf8";
        $result = mysqli_query($link, $query_enc) or die("Ошибка " . mysqli_error($link));


        if(isset($_POST["login"])){

            if(!empty($_POST['username']) && !empty($_POST['password'])) {
                $username=htmlspecialchars($_POST['username']);
                $password=htmlspecialchars($_POST['password']);

                $query ="SELECT * FROM `doctors` WHERE last_name='".$username."' AND `password`='".md5($password)."'";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); // результурующая запроса
                $numrows=mysqli_num_rows($result);

                if($numrows!=0)
                {
                    $row=mysqli_fetch_assoc($result); // Делает ассоциативный массив из полученных данных

                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_last_name'] = $row['last_name'];
                    $_SESSION['user_fathers_name'] = $row['fathers_name'];
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_cabinet_id'] = $row['cabinet_id'];
                    $_SESSION['user_rang'] = $row['doc_rang'];
                    $_SESSION['user_status'] = $row['active'];

                } else { echo "Неправильный логин или пароль"; }
            } else { echo "Заполните все поля"; }
        }

        ?>



            <?php if(!isset($_SESSION["user_name"])):?>

            <div id="login">
                <h1>Вход</h1>
                <form method="POST" name="loginform">
                    <p><label for="user_login">Фамилия пользователя<br>
                            <input id="username" name="username" size="11" type="text" value="" required
                                placeholder="Фамилия"></label></p>

                    <p><label for="user_pass">Пароль<br>
                            <input id="password" name="password" size="11" type="password" value="" required
                                placeholder="Ваш пароль"></label></p>

                    <p><input name="login" type="submit" value="Войти"></p>
                    <p>Еще не зарегистрированы?<a href="reg.php">Регистрация</a>!</p>
                </form>
            </div>

            <?php elseif($_SESSION['user_status'] == 0): ?>
            <div>
                <h2>Ваша учётная запись, ещё не активна</h2>
                <p>Если вы считаете, что это ошибка, <a href="contacts.php">свяжитесь</a> с нами</p>
                <p><a href="logout.php">Выйти</a></p>
            </div>

            <?php else: ?>


            <div id="auth_user">
                <a href="service_doc.php"> <img src="user.png" alt="User_face"></a>
                <p> <?php echo $_SESSION["user_last_name"]; ?></p>

                <p> <?php echo $_SESSION["user_name"]; ?>
                    <?php echo $_SESSION["user_fathers_name"]; ?>
                </p>
                <p> <button><a href="edit_doc.php">Редактировать профиль</a></button>
                    <button formaction="logout.php"><a href="logout.php">Выйти</a></button>
                </p>

            </div>


            <?php endif; ?>


        </div>

        <!--Обработка формы входа на сайт-->


        <!--    ТО что будет в середине сайта-->
        <div id="article">
            <?php if(!isset($_SESSION["user_name"])):?>
            <h2>Добро пожаловать!</h2>
            <p>Вы находитесь на рабочей странице доктора</p>
            <p>Для того, что бы использовать функционал врача или просмореть личные данные, вам ненеобходимо
                <a href="#">войти</a> или <a href="reg_doc.php  ">зарегестрироваться</a> на сайте.
            </p>

            <?php elseif($_SESSION['user_status'] == 0): ?>
            <div>
                <h2>Ваша учётная запись, ещё не активна</h2>
                <p>Если вы считаете, что это ошибка, <a href="contacts.php">свяжитесь</a> с нами</p>
                <p><a href="logout.php">Выйти</a></p>

            </div>

            <?php else: ?>

            <?php
            // Задаём кодировку
            $query_enc = "SET NAMES utf8";
            $result = mysqli_query($link, $query_enc) or die("Ошибка " . mysqli_error($link));

            // 1) Что бы рабоать с пациентами, нужно найти все купоны, где док ид == юзер ид
            // В цикле:
            // Вычленить данные пользователя по pacient_id (ФИО, Год рождения, посл посещение, номер мед карты)
            // Вывести таблицу


//            1) Получить id пользователя



//          2) Получить все купоны где указан доктор

            $user_id = $_SESSION['user_id'];
            $query = "SELECT `id`,  `patients_id`, `patients_med_card_id`  FROM `registration_coupon` WHERE `doctors_id` = "."'$user_id'";
            $coupons = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); // ЗаписИ о купонах
            $rows = mysqli_num_rows($coupons);

            // Купонов сейчас дофига и по ним нужно делать цикл вывода таблицы

            if ($rows > 0){
                echo "<table width='100%'>  <tr>  <th>№</th>  <th>ФИО</th> <th>Год рождения</th>  <th>Посл. визит</th>  <th>Принять</th>  <th>Отменить</th> </tr>";
                // Парсим все купоны
                for ($i = 0; $i < $rows; $i++){
                    $row = mysqli_fetch_row($coupons);
//
//          3)  из него досать id пациента
//          4) По id пациента получить ФИО, дату и посещение
                    $patient_id = $row[1];

                    // Данные о пациенте
                    $query = "SELECT `name`, `last_name`, `fathers_name`, `birthday`,  `last_visit` FROM `patients` WHERE `id` = "."'$patient_id'";
                    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                    $patient_row = mysqli_fetch_row($result); // Запись о пациенте
                    $patient_full_name = "".$patient_row[1]." ".$patient_row[0]." ".$patient_row[2];

                    echo "<tr>";

                    echo "<td>$row[0]</td>";
                    echo "<td>$patient_full_name</td>";
                    echo "<td>$patient_row[3]</td>";
                    echo "<td>$patient_row[4]</td>";



                    $patient_full_name = "".$patient_row[1]."_".$patient_row[0]."_".$patient_row[2];
                    $choice_link = "patient_card.php?c_id=".$row[0]."&pat_full=".$patient_full_name."&pat_bd=".$patient_row[3]."&card_id=".$row[2]."&l=1";
                    echo "<td><a href=$choice_link style=' color: green'> Принять </a> </td>";

                    $del_link = "del_coupon.php?k=1&id=".$row[0];
                    echo "<td><a href=$del_link style=' color: red'> Удалить </a> </td>";

                    echo "</tr>";

                }
                echo "</table>";

            } else {
                echo "У вас нет записей";
            }
            ?>

            <?php endif; ?>
        </div>


    </div>



    <div id="footer">
        <p>Contacts: chyvak357@gmail.com</p>
        <p>Copyright © MySyte.com, 2022</p>
    </div>



</body>

</html>