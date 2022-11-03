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
                <li><a href="reg.php">Регистрация</a></li>
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
                    <p>Еще не зарегистрированы?<a href="reg_doc.php">Регистрация</a>!</p>
                </form>
            </div>

            <?php elseif($_SESSION['user_status'] == 0): ?>
            <div>
                <h2>Ваша учётная запись, ещё не активна</h2>
                <p>Если вы считаете, что это ошибка, <a href="contacts.php">свяжитесь</a> с нами</p>
            </div>

            <?php else: ?>


            <div id="auth_user">
                <a href="service_doc.php"> <img src="user.png" alt="User_face"></a>
                <p> <?php echo $_SESSION["user_last_name"]; ?></p>

                <p> <?php echo $_SESSION["user_name"]; ?>
                    <?php echo $_SESSION["user_fathers_name"]; ?>
                </p>
                <p> <button><a href="edit_doc.php.php">Редактировать профиль</a></button>
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
                <a href="#">войти</a> или <a href="reg_doc.php">зарегестрироваться</a> на сайте.
            </p>

            <?php elseif($_SESSION['user_status'] == 0): ?>
            <div>
                <h2>Ваша учётная запись, ещё не активна</h2>
                <p>Если вы считаете, что это ошибка, <a href="contacts.php">свяжитесь</a> с нами</p>
            </div>

            <?php else: ?>

            <?php
            // Задаём кодировку
            $query_enc = "SET NAMES utf8";
            $result = mysqli_query($link, $query_enc) or die("Ошибка " . mysqli_error($link));

            if(isset($_GET['c_id'])){$coupon_id = $_GET['c_id']; }
            if(isset($_GET['pat_full'])){ $patient_full = $_GET['pat_full'];}
            if(isset($_GET['pat_bd'])){$pat_bd = $_GET['pat_bd'];}
            if(isset($_GET['card_id'])){$card_id = $_GET['card_id'];}


            echo "<h1>".$patient_full."</h1>"."<br>";
            echo "Рождён: ".$pat_bd."<br>";

// Получить все  болячки из карты

            $query = "SELECT `illness` FROM `med_card` WHERE `id` = "."'$card_id'";
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
            $row = mysqli_fetch_row($result);


            ?>


            <form method="POST" ">
                <p><b>Редактиорвание мед карты: </b></p>
                <p><textarea name=" illness"><?php echo $row[0]; ?></textarea></p>
                <p><input type="submit" value="Завершить приём"></p>
            </form>

            <?php
            if(isset($_POST['illness'])){$illness = $_POST['illness'];
                $query = "UPDATE `med_card` SET `illness`='$illness', `num_visits`= `num_visits` +1 WHERE `id`= '$card_id'";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                $del_link = "del_coupon.php?id=".$coupon_id."&k=1";

                header("location:".$del_link);
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