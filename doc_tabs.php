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

        <!--Обработка формы входа на сайт-->


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

            <!--
    Действия:
    Просмотреть/ удалить всех докторов !!! При удалении удалять и купоны (если есть)
    Просмотреть/ удалить активных докторов (с функц деактив) !!! При удалении удалять и купоны (если есть)
    Просмотреть/ удалить неактивных (с функц актив)

    Сортировка по ФИО
    -->


            <p> Выберете действие</p>

            <form method="post">
                <p><select size="10" multiple name="tables" style=" width: 40%">
                        <option value="all_doctors"> Выбрать всех докторов</option>";
                        <option value="active_doctors"> Выбрать активных докторов</option>";
                        <option value="noactive_doctors"> Выбрать неактивных докторов</option>";
                    </select></p>
                <p><input type="submit" value="Выбрать"></p>
            </form>

            <?php

            if (isset($_POST["tables"])) {

                if ($_POST['tables'] == 'active_doctors') {
//                    ORDER BY `last_name`";
                    $query = "SELECT * FROM `doctors` WHERE `active` = 1";
                    $result_docs = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                    $rows = mysqli_num_rows($result_docs); // Вернёт количество полученных строк

                } elseif ($_POST['tables'] == 'noactive_doctors') {
                    $query = "SELECT * FROM `doctors` WHERE `active` = 0";
                    $result_docs = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                    $rows = mysqli_num_rows($result_docs); // Вернёт количество полученных строк

                } else {

                    $query = "SELECT * FROM `doctors`";
                    $result_docs = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                    $rows = mysqli_num_rows($result_docs); // Вернёт количество полученных строк

                }

                // id,"name","last_name","fathers_name","phone_numb","password","active","employment_date","cabinet_id","doc_rang"
                echo "<table width='100%'>  <tr>   <th>ID</th> <th>ФИО</th> <th>Спец-ь</th> <th>Телефон</th>  <th>Каб.</th> <th>Назначить кабинет</th>  <th>Статус</th> <th>Вкл</th> <th>Выкл</th> <th>Удалить</th></tr>";

                for ($i = 0; $i < $rows; $i++) {
                    $doc_row = mysqli_fetch_assoc($result_docs);
                    // $doc_row = mysqli_fetch_row($result_docs);
                    

                    $doc_full_name = "" . $doc_row['last_name'] . " " . $doc_row['name'] . " " . $doc_row['fathers_name'];
                    $cab_id = $doc_row['cabinet_id'];
                    $cab_num = "Н/Д";
                    if ($doc_row['active'] == 0) {
                        $status = "Не активен";
                    } else {
                        $status = "Активен";
                    }


                    // if($cab_id != 1 ){
                    $query = "SELECT `number` FROM `cabinet` WHERE `id` = " . $cab_id;
                    // echo "<h1>AAAAA</h1>";
                    // echo $query;
                    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                    $cab_row = mysqli_fetch_row($result);
                    $cab_num = $cab_row[0];
                    // }


                    echo "<tr>";
                    
                    echo "<td>".$doc_row['id']."</td>";
                    echo "<td>$doc_full_name</td>";
                    echo "<td>".$doc_row['doc_rang']."</td>";
                    echo "<td>".$doc_row['phone_numb']."</td>";
                    echo "<td>$cab_num</td>";

                    // Назначить кабинет
                    $links = "set_doc_cab.php?cab_id=" . $cab_id . "&doc_id=" . $doc_row['id'];
                    // $links = "set_doc_cab.php?cab_id=" . $cab_id . "&doc_id=" . $doc_row[0];
                    echo "<td><a href='$links'>Каб</a> </td>";

                    echo "<td>$status</td>";

                    // Активировать
                    echo "<td><a href='action_doc.php?act=1&id=" . $doc_row['id'] . "'>++</a> </td>";
                    // echo "<td><a href='action_doc.php?act=1&id=" . $doc_row[0] . "'>++</a> </td>";

                    // Деактивировать
                    echo "<td><a href='action_doc.php?act=0&id=" . $doc_row['id'] . "'>+-</a> </td>";
                    // echo "<td><a href='action_doc.php?act=0&id=" . $doc_row[0] . "'>+-</a> </td>";

                    // Удалить
                    echo "<td><a href='action_doc.php?act=3&id=" . $doc_row['id'] . "'>--</a> </td>";
                    // echo "<td><a href='action_doc.php?act=3&id=" . $doc_row[0] . "'>--</a> </td>";


                    echo "</tr>";
                }
                echo "</table>";


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