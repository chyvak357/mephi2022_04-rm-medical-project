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
                <li><a href="#">Контакты</a></li>
                <?php if(!isset($_SESSION["user_name"])):?>
                <li><a href="reg.php">Регистрация</a></li>
                <?php else: ?>
                <li><a href="service.php">Профиль</a></li>
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

                $query ="SELECT * FROM patients WHERE last_name='".$username."' AND phone_numb='".$password."'";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); // результурующая запроса
                $numrows=mysqli_num_rows($result);

                if($numrows!=0)
                {
                    while($row=mysqli_fetch_assoc($result)) // Делает ассоциативный массив из полученных данных
                    {

//                    Разобратся с тем, что вычленять
                        $db_username=$row['name'];
                        $db_password=$row['phone_numb'];
                        $db_last_name=$row['last_name'];
                        $db_fathers_name=$row['fathers_name'];
                    }

//                Проверка на правильный ввод
                    if($username == $db_last_name && $password == $db_password)
                    {
                        $_SESSION['user_name']=$db_username;
                        $_SESSION['user_last_name']=$db_last_name;
                        $_SESSION['user_fathers_name']=$db_fathers_name;
                        $_SESSION['user_phone_num'] = $db_password;
                    }
                } else { echo "Неправильный логин или пароль"; }
            } else { echo "Заполните все поля"; }
        }
        ?>



            <?php if(!isset($_SESSION["user_name"])  && !isset($_SESSION['user_rang']) ):?>

            <div id="login">
                <h1>Вход</h1>
                <form method="POST" name="loginform">
                    <p><label for="user_login">Фамилия пользователя<br>
                            <input id="username" name="username" size="11" type="text" value="" required
                                placeholder="Фамилия"></label></p>

                    <p><label for="user_pass">Номер телефона<br>
                            <input id="password" name="password" size="11" type="password" value="" required
                                placeholder="88005553535"></label></p>

                    <p><input name="login" type="submit" value="Войти"></p>
                    <p>Еще не зарегистрированы?<a href="reg.php">Регистрация</a>!</p>
                </form>
            </div>

            <?php else: ?>

            <div id="auth_user">
                <a href="service.php"> <img src="user.png" alt="User_face"></a>
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
            <p>Вы находитесь на странице обслуживания населениея</p>
            <p>Для того, что бы записать к врачу, просмореть личные данные, записи и карут болезни, вам ненеобходимо
                <a href="#">войти</a> или <a href="reg.php">зарегестрироваться</a> на сайте.
            </p>
            <p>Если вы хотите сотрудничать или работать в поликлинние, обратитесь к вкладке <a href="#">"Контакты"</a>
            </p>
            <?php else: ?>

            <?php

            $phone_num = $_SESSION['user_phone_num'];
            $query = "SELECT * FROM `patients` WHERE `phone_numb` = '$phone_num'";
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
            $row=mysqli_fetch_row($result);

            // Определение значений касательно пользователя
            if ($result){
                $id_insurance = $row[9];
                $l_name = $row[2];
                $name =  $row[1];
                $f_name = $row[3];
                $b_day =  $row[4];
                $location = $row[6];


                $query = "SELECT  `num_insurance`, `company`, `date of issue`, `shelf_life` FROM `health_insurance` WHERE `id` = '$id_insurance'";
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                $row=mysqli_fetch_row($result);

                $num_insurance = $row[0];
                $company = $row[1];
                $issue_date   = $row[2];
                $self_life    = $row[3];
            }



            ?>


            <form method="POST">
                Фамилия: <input type="text" name="l_name" value="<?php echo $l_name; ?>" maxlength="45" required
                    placeholder="Иванов" autofocus /><br><br>
                Имя: <input type="text" name="name" value="<?php echo $name; ?>" maxlength="45" required
                    placeholder="Иван" /><br><br>
                Отчество: <input type="text" name="f_name" value="<?php echo $f_name; ?>" maxlength="45" required
                    placeholder="Иванович" /><br><br>
                Дата рождения: <input type="date" name="b_day" value="<?php echo $b_day; ?>" maxlength="10" required
                    placeholder="гггг-мм-дд" /><br><br>

                Адрес проживания: <input type="text" name="location" value="<?php echo $location; ?>" maxlength="80"
                    required placeholder="пр-Вернандского 78" /><br><br>

                Номер страхового полиса: <input type="text" name="num_insurance" value="<?php echo $num_insurance; ?>"
                    maxlength="16" placeholder="16 цифр" required pattern="[0-9]{16}" /><br><br>
                Название страховой компании: <input type="text" name="company" value="<?php echo $company; ?>"
                    maxlength="30" placeholder="ООО Лечим всех" required /><br><br>
                Дата выдачи: <input type="date" name="issue_date" value="<?php echo $issue_date; ?>" maxlength="10"
                    placeholder="гггг-мм-дд" /><br><br>
                Срок действия (лет): <input type="number" name="self_life" value="<?php echo $self_life; ?>"
                    maxlength="10" placeholder="4" pattern="[0-9]{10}" /><br><br>

                <input type="submit" value="Отправить новые данные">
            </form>


            <?php






            if (
                isset($_POST['l_name'])&&
                isset($_POST['name'])&&
                isset($_POST['f_name'])&&
                isset($_POST['b_day'])&&
                isset($_POST['location'])&&
                isset($_POST['num_insurance'])&&
                isset($_POST['company'])
            ) {
                $l_name = htmlentities(mysqli_real_escape_string($link, $_POST['l_name']));
                $name = htmlentities(mysqli_real_escape_string($link, $_POST['name']));
                $f_name = htmlentities(mysqli_real_escape_string($link, $_POST['f_name']));
                $b_day = htmlentities(mysqli_real_escape_string($link, $_POST['b_day']));
                $location = htmlentities(mysqli_real_escape_string($link, $_POST['location']));
                $num_insurance = htmlentities(mysqli_real_escape_string($link, $_POST['num_insurance']));
                $company = htmlentities(mysqli_real_escape_string($link, $_POST['company']));

            }

//  Необязательные для ввода поля.


            if ( isset($_POST['issue_date'])  ) {     $issue_date = htmlentities(mysqli_real_escape_string($link, $_POST['issue_date'])); }
            if ( isset($_POST['self_life'])  ) {      $self_life = htmlentities(mysqli_real_escape_string($link, $_POST['self_life'])); }





            // Данные пациета
            $query = "UPDATE `patients` SET `name`='$name',`last_name`='$l_name',`fathers_name`='$f_name', `birthday`='$b_day',`location`='$location'
                     WHERE `phone_numb` = '$phone_num'";
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

            // Мед страховка
            $query = "UPDATE `health_insurance` SET `num_insurance`='$num_insurance', `company`='$company',`date of issue`='$issue_date',`shelf_life`='$self_life' WHERE `id` = '$id_insurance'";
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));



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