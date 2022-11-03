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
                <?php if(!isset($_SESSION["user_name"])):?>
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
                <p><a href="logout.php">Выйти</a></p>
            </div>

            <?php else: ?>


            <div id="auth_user">
                <a href="service_doc.php"> <img src="user.png" alt="User_face"></a>
                <p> <?php echo $_SESSION["user_last_name"]; ?></p>

                <p> <?php echo $_SESSION["user_name"]; ?>
                    <?php echo $_SESSION["user_fathers_name"]; ?>
                </p>
                <p> <button><a href="#">Редактировать профиль</a></button>
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

            $phone = $_SESSION['user_id'];
            $query = "SELECT * FROM `doctors` WHERE `id` ='".$phone."'";
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
            $row=mysqli_fetch_row($result);

            // Определение значений касательно пользователя
            if ($result){
                $l_name = $row[2];
                $name =  $row[1];
                $f_name = $row[3];
                $phone = $row[4];
                $doc_rang = $row[8];

            }



            ?>


            <form method="POST">
                Фамилия: <input type="text" name="l_name" value="<?php echo $l_name; ?>" maxlength="45" required
                    placeholder="Иванов" autofocus /><br><br>
                Имя: <input type="text" name="name" value="<?php echo $name; ?>" maxlength="45" required
                    placeholder="Иван" /><br><br>
                Отчество: <input type="text" name="f_name" value="<?php echo $f_name; ?>" maxlength="45" required
                    placeholder="Иванович" /><br><br>

                Номер телефона:<input type="text" name="phone" value="<?php echo $phone; ?>" maxlength="11"
                    required /><br><br>


                Специальность:
                <p><select size="8" multiple name="specialist">
                        <option disabled>Новая специальность</option>
                        <option value="<?php echo $doc_rang; ?>" selected><?php echo $doc_rang; ?></option>
                        <option value="Участковый">Участковый</option>
                        <option value="Уролог">Уролог</option>
                        <option value="Хирург">Хирург</option>
                        <option value="Мед сестра">Мед сестра</option>
                        <option value="Отолоринголог">Отолоринголог</option>
                        <option value="Офтальмолог">Офтальмолог</option>
                    </select></p> <br><br>

                <p>Для смены пароля обратитесь к администрации</p>

                <input type="submit" value="Отправить новые данные">
            </form>


            <?php


            if (
                isset($_POST['l_name'])&&
                isset($_POST['name'])&&
                isset($_POST['f_name'])&&
                isset($_POST['phone'])&&
                isset($_POST['specialist'])

            ) {
                $l_name = htmlentities(mysqli_real_escape_string($link, $_POST['l_name']));
                $name = htmlentities(mysqli_real_escape_string($link, $_POST['name']));
                $f_name = htmlentities(mysqli_real_escape_string($link, $_POST['f_name']));
                $phone = htmlentities(mysqli_real_escape_string($link, $_POST['phone']));
                $doc_rang = htmlentities(mysqli_real_escape_string($link, $_POST['specialist']));


            }


            $phone_num = $_SESSION['user_id'];
            // Данные доктора
            $query = "UPDATE `doctors` SET `name`='$name',`last_name`='$l_name',`fathers_name`='$f_name', `phone_numb`='$phone',`doc_rang`='$doc_rang'
                     WHERE `id` = '$phone_num'";
            // echo $query;
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
            echo "Данные успешно обнвлены";
            $_SESSION['user_name'] = $name;
            $_SESSION['user_fathers_name'] = $f_name;
            $_SESSION['user_last_name'] = $l_name;


// закрываем подключение
            mysqli_close($link);

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