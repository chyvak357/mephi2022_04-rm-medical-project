<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title> Главная страница Мед учереждения</title>

    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
    /*        Испольщзовать на главной странице */
    /*        Переопределяем стиль для среднего блока, что бы растянуть его по всей ширине*/
    #article {
        background-color: rgba(247, 247, 247, 0.5);
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        margin-left: 0;
        margin-right: 20%;
        padding: 15px;
        width: 100%;
    }
    </style>


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
                <li><a href="index.php">Главная</a></li>

            </ul>
        </div>
    </div>





    <div class="wrapper">



        <!--    ТО что будет в середине сайта-->
        <div id="article">
            <h2>Регистрация нового врача в системе поликлинники</h2>
            <p>Пожалуйста, заполните все необходимы поля для создания учётной записи</p>
            <p>Вы сможете приступить к работе после рассмотрения заявки администратором</p>


            <form method="POST">

                Фамилия: <input type="text" name="l_name" maxlength="45" required placeholder="Иванов"
                    autofocus /><br><br>
                Имя: <input type="text" name="name" maxlength="45" required placeholder="Иван" /><br><br>
                Отчество: <input type="text" name="f_name" maxlength="45" required placeholder="Иванович" /><br><br>
                Номер телефона:<input type="text" name="phone_num" maxlength="11" required placeholder="88005553535"
                    pattern="[0-9]{11}" /><br><br>
                Пароль: <input type="text" name="password" maxlength="45" required placeholder="Ваш пароль" /><br><br>

                <p><select size="7" multiple name="specialist">
                        <option disabled>Выберите специальность</option>
                        <option value="Участковый" selected>Участковый</option>
                        <option value="Уролог">Уролог</option>
                        <option value="Хирург">Хирург</option>
                        <option value="Мед сестра">Мед сестра</option>
                        <option value="Отолоринголог">Отолоринголог</option>
                        <option value="Офтальмолог">Офтальмолог</option>
                    </select></p>

                <input type="submit" value="Отправить">
            </form>

        </div>


    </div>

    <?php
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

$query2 = "SET NAMES utf8";
$result = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link)); // результурующая запроса


$l_name = "Нет сведений";
$name =  "Нет сведений";
$f_name = "Нет сведений";
$password =  "pass";
$phone_num = "00000000000";
$specialist =  "Никто";
$employment_date = date('Y/m/d');


if (
    isset($_POST['l_name'])&&
    isset($_POST['name'])&&
    isset($_POST['f_name'])&&
    isset($_POST['password'])&&
    isset($_POST['phone_num'])&&
    isset($_POST['specialist'])
) {
    $l_name = htmlentities(mysqli_real_escape_string($link, $_POST['l_name']));
    $name = htmlentities(mysqli_real_escape_string($link, $_POST['name']));
    $f_name = htmlentities(mysqli_real_escape_string($link, $_POST['f_name']));
    $password = md5(htmlentities(mysqli_real_escape_string($link, $_POST['password'])));
    $phone_num = htmlentities(mysqli_real_escape_string($link, $_POST['phone_num']));
    $specialist = htmlentities(mysqli_real_escape_string($link, $_POST['specialist']));
}


$rows = 1000;
$query = "SELECT * FROM `doctors` WHERE `phone_numb` ='$phone_num'";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
$rows=mysqli_num_rows($result);

if ($rows != 0 ){
    echo "Пользователь с таким номером уже существует "."<br>";
} else {

    $query = "INSERT INTO `doctors`(`name`, `last_name`, `fathers_name`, `phone_numb`, `password`, `employment_date`, `doc_rang`) 
              VALUES ('$name', '$l_name', '$f_name', '$phone_num', '$password', '$employment_date', '$specialist')";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    if ($result){ echo "Аккаунт успешно создан";}
}

// закрываем подключение
mysqli_close($link);
?>



    <div id="footer">
        <p>Contacts: chyvak357@gmail.com</p>
        <p>Copyright © MySyte.com, 2022</p>
    </div>

</body>

</html>