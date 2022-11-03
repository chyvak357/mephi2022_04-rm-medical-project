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
                <p> <button><a href="edit_user.php">Редактировать профиль</a></button>
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

            <div id="schedule">
                <div class="schedule">
                    <p>Выберете специальность</p>
                    <form method="post">
                        <p><select size="10" multiple name="specialist">
                                <option value="Участковый" selected>Участковый</option>
                                <option value="Уролог">Уролог</option>
                                <option value="Хирург">Хирург</option>
                                <option value="Мед сестра">Мед сестра</option>
                                <option value="Отолоринголог">Отолоринголог</option>
                                <option value="Офтальмолог">Офтальмолог</option>
                            </select></p>
                        <p><input type="submit" value="Показать специалистов"></p>
                    </form>
                </div>
                <div class="schedule">
                    <p>Список доступных врачей</p>
                    <?php

                    $link = mysqli_connect($host, $user, $password, $database)
                    or die("Ошибка ".mysqli_error($link));

                    $query_enc = "SET NAMES utf8";
                    $result = mysqli_query($link, $query_enc) or die("Ошибка " . mysqli_error($link));

                    if (isset($_POST["specialist"])) {

                        $choice = $_POST["specialist"];


                        $query = "SELECT `name`, `last_name`, `cabinet_id`, `id` FROM `doctors` WHERE `active` = 1 AND `doc_rang` = '".$choice."'";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                        $rows = mysqli_num_rows($result); // Вернёт количество полученных строк
                        if ($rows != 0){


                            echo "<table style=' border-collapse: collapse; width: inherit;'>  <tr>    <th>Имя</th>    <th>Фамилия</th>  <th>Кабинет</th>   </tr>";
                            for ($i = 0 ; $i < $rows ; ++$i)
                            {
                                $row = mysqli_fetch_row($result); // Извелкаем отдельную строку, а указатель перезодит к новой
                                $id_cabinet = $row[2];


                                $query = "SELECT `number` FROM `cabinet` WHERE id = '".$id_cabinet."'";
                                $result_cab = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                                $row_cab_id = mysqli_fetch_assoc($result_cab);
                                $num_cabinet = $row_cab_id["number"];

                                $row[2] = $num_cabinet;
                                echo "<tr>";
                                for ($j = 0 ; $j < 3 ; ++$j) echo "<td>$row[$j]</td>"; // Перебор ячеек текущей строки
                                echo "</tr>";
                            }
                            echo "</table>";

                        } else { echo "Специалистов не найдено";}
                    }

                    if (isset($_POST["specialist_2state"])){
        
                        $doc_id = $_POST["specialist_2state"];
        
                        $phone = $_SESSION['user_phone_num'];
        
                        $query = "SELECT `id`, `med_card_id`, `health_insurance_id` FROM `patients` WHERE `phone_numb` = "."'$phone'";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                        $row=mysqli_fetch_row($result);
        
        
                        $patient_id = $row[0];
                        $patient_med_card_id = $row[1];
                        $patient_health_insurance_id = $row[2];
                        $date = date('Y/m/d');
                        $coup_num = rand ( 1, 100);
        
                        $query = "INSERT INTO `registration_coupon`(`num_coupon`, `reg_date`, `doctors_id`, `patients_id`, `patients_med_card_id`, `patients_health_insurance_id`) 
                                            VALUES ( '$coup_num', '$date', '$doc_id', '$patient_id', '$patient_med_card_id', '$patient_health_insurance_id')";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                        echo "<h1>Запись прошла успешно</h1>";
                    }


                    ?>
                </div>
                <div class="schedule">
                    <p>Выберете специалиста</p>

                    <form method="post">

                        <p><select size="10" multiple name="specialist_2state">
                                <?php
                                mysqli_data_seek($result, 0);

                                for ($i = 0 ; $i < $rows ; ++$i){
                                    $row = mysqli_fetch_row($result); // Извелкаем отдельную строку, а указатель перезодит к новой

                                    echo "<option ";
                                    echo "value='"."$row[3]"."'>";
                                    echo $row[0] . " ". $row[1];
                                    echo "</option>";
                                }
                                ?>
                            </select></p>
                        <p><input type="submit" value="Записаться"></p>
                    </form>
                </div>
            </div>


          




            <?php endif; ?>
        </div>


    </div>



    <div id="footer">
        <p>Contacts: chyvak357@gmail.com</p>
        <p>Copyright © MySyte.com, 2022</p>
    </div>



</body>

</html>