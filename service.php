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


            <?php if(!isset($_SESSION["user_name"])):?>

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
                <p> <button><a href="edit_user.php">Редактировать профиль</a></button>
                    <button formaction="logout.php"><a href="logout.php">Выйти</a></button>
                </p>
            </div>

            <?php endif; ?>


        </div>

        <!--Обработка формы входа на сайт-->


        <!--    ТО что будет в середине сайта-->
        <div id="article">
            <?php if(!isset($_SESSION["user_name"])  && !isset($_SESSION['user_rang']) ):?>
            <h2>Добро пожаловать!</h2>
            <p>Вы находитесь на странице обслуживания населениея</p>
            <p>Для того, что бы записать к врачу, просмореть личные данные, записи и карут болезни, вам ненеобходимо
                <a href="#">войти</a> или <a href="reg.php">зарегестрироваться</a> на сайте.
            </p>
            <p>Если вы хотите сотрудничать или работать в поликлинние, обратитесь к вкладке <a href="#">"Контакты"</a>
            </p>
            <?php else: ?>

            <p><a href="user.php">Записи</a></p>
            <p> <a href="register_to_doc.php">Записаться к врачу</a> </p>
            <p> <a href="edit_user.php">Редактировать профиль </a></p>

            <?php endif; ?>
        </div>


    </div>



    <div id="footer">
        <p>Contacts: chyvak357@gmail.com</p>
        <p>Copyright © MySyte.com, 2022</p>
    </div>



</body>

</html>