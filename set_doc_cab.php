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
                <li><a href="logout.php">Выход</a></li>
                <li><a href="index.php">Главная</a></li>
                <li><a href="staff_main.php">Профиль</a></li>
                <li><a href="pat_tabs.php">Упраление пациентами</a></li>
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
                $password=md5(htmlspecialchars($_POST['password']));

                $query ="SELECT * FROM management WHERE login='".$username."' AND password='".$password."'";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); // результурующая запроса
                $numrows=mysqli_num_rows($result);

                if($numrows!=0)
                {
                    while($row=mysqli_fetch_assoc($result)) // Делает ассоциативный массив из полученных данных
                    {
                        $_SESSION['user_login']= $row['login'];
                        $_SESSION['user_position']= $row['position'];
                    }
                } else { echo "Неправильный логин или пароль"; }
            } else { echo "Заполните все поля";}
        }
        ?>



            <?php if(!isset($_SESSION["user_login"])):?>

            <div id="login">
                <h1>Вход</h1>

                <form method="POST" name="loginform">
                    <p><label for="user_login">Логин<br>
                            <input id="username" name="username" size="11" type="text" value="" required
                                placeholder="login"></label></p>

                    <p><label for="user_pass">Пароль<br>
                            <input id="password" name="password" size="11" type="text" value="" required
                                placeholder="password"></label></p>

                    <p><input name="login" type="submit" value="Войти"></p>
                </form>
            </div>

            <?php else: ?>


            <div id="auth_user">
                <a href="staff_main.php"> <img src="user.png" alt="User_face"></a>
                <p> <?php echo $_SESSION["user_login"]; ?></p>
                <p> <?php echo $_SESSION["user_position"]; ?> </p>
                <a href="logout.php"></a>
                <button formaction="logout.php"><a href="logout.php">Выйти</a></button>
                </p>

            </div>


            <?php endif; ?>


        </div>


        <!--    ТО что будет в середине сайта-->
        <div id="article">
            <?php if(!isset($_SESSION["user_login"])):?>
            <h2>Добро пожаловать!</h2>
            <p>Вы находитесь на служебной странице</p>
            <p>Для того, что бы записать к врачу, просмореть личные данные, записи и карут болезни, вам ненеобходимо
                <a href="index.php">войти</a> или <a href="reg.php">зарегестрироваться</a> на сайте.
            </p>
            <p>Если вы хотите сотрудничать или работать в поликлинние, обратитесь к вкладке <a
                    href="contacts.php">"Контакты"</a></p>
            <?php else: ?>

            <?php

                if(isset($_GET['cab_id']) && isset($_GET['cab_id'])) {
                    $cab_id = $_GET['cab_id'];
                    $doc_id = $_GET['doc_id'];
                } else {
                    echo 'Ошибка: действие не может быть выполнено! <br>';
                    echo '<a href="staff_main.php">Назад</a>';
                }


            ?>

            <form method="POST">
                Номер кабинета: <input type="number" name="new_num" required /><br><br>
                <input type="submit" value="Отправить">
            </form>

            <?php
        // print_r($_POST);
        // print_r($_GET);
                if(isset($_POST['new_num']) && isset($_GET['cab_id'])) {
                    $new_num = $_POST['new_num'];

                    $query = "SELECT `id` FROM `cabinet` WHERE `number` = '" . $new_num . "'";
                    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                    $row = mysqli_fetch_assoc($result);
                    $cabinet_id = $row ? $row['id'] : null;
                    
                    if($cabinet_id == null) {
                        $result = mysqli_query($link, "SELECT MAX(id) as id FROM `cabinet`") or die("Ошибка " . mysqli_error($link));
                        $row = mysqli_fetch_assoc($result);
                        $cabinet_id = $row['id'] + 1;
                        $query = "INSERT INTO `cabinet` (`id`, `number`) VALUES ( '" . $cabinet_id . "', '" . $new_num . "')";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                    }

                    $query = "UPDATE `doctors` SET `cabinet_id`='" . $cabinet_id . "' WHERE `id` = '" . $doc_id . "'";
                    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

                    // $query = "DELETE FROM `cabinet` WHERE `id`='" . $cab_id . "'";
                    // $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                    // header("location:staff_main.php");

                }

                mysqli_close($link);
                ?>


            <?php endif; ?>


        </div>



        <div id="footer">
            <p>Contacts: chyvak357@gmail.com</p>
            <p>Copyright © MySyte.com, 2022</p>
        </div>



</body>

</html>