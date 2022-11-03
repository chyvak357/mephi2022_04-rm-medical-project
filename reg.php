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
            <h2>Регистрация нового пользователя в системе поликлинники</h2>
            <p>Пожалуйста, заполните все неоюходимы поля для создания учётной записи и мед карты</p>

            <!--        pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"-->
            <form method="POST">
                Фамилия: <input type="text" name="l_name" maxlength="45" required placeholder="Иванов"
                    autofocus /><br><br>
                Имя: <input type="text" name="name" maxlength="45" required placeholder="Иван" /><br><br>
                Отчество: <input type="text" name="f_name" maxlength="45" required placeholder="Иванович" /><br><br>
                Дата рождения: <input type="date" name="b_day" maxlength="10" required
                    placeholder="гггг-мм-дд" /><br><br>

                Номер телефона: <input type="text" name="phone_num" maxlength="11" required placeholder="88005553535"
                    pattern="[0-9]{11}" /><br><br>
                Адрес проживания: <input type="text" name="location" maxlength="80" required
                    placeholder="пр-Вернандского 78" /><br><br>
                Дата последнего посещения: <input type="date" name="last_visit" maxlength="10"
                    placeholder="гггг-мм-дд" /><br><br>

                Номер страхового полиса: <input type="number" name="num_insurance" maxlength="16" placeholder="16 цифр"
                    required pattern="[0-9]{16}" /><br><br>
                Название страховой компании: <input type="text" name="company" maxlength="30"
                    placeholder="ООО Лечим всех" required /><br><br>
                Дата выдачи: <input type="date" name="issue_date" maxlength="10" placeholder="гггг-мм-дд" /><br><br>
                Срок действия (лет): <input type="number" name="self_life" maxlength="10" placeholder="4"
                    pattern="[0-9]{10}" /><br><br>

                Болезни за пол года: <input type="text" name="last_illness" maxlength="50"
                    placeholder="ветрянка, оспа, грипп..." /><br><br>
                Количество посещений за пол года: <input type="number" name="last_counts" maxlength="3" placeholder="0"
                    pattern="[0-9]" /><br><br>


                <input type="submit" value="Отправить">
            </form>

        </div>


    </div>

    <?php
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

$query2 = "SET NAMES utf8";
$result = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link)); // результурующая запроса

$key = 1;            // Ключ, полс епроверки должен быть = 1, иначе, в бд ничего не добавят и покажется reg_errors
$reg_errors = "Ошибочка: ";  // Финальное сообщение, если будут ошибки в введённыйх данных


$l_name = "Нет сведений";
$name =  "Нет сведений";
$f_name = "Нет сведений";
$b_day =  "2000-01-01";
$phone_num = "00000000000";
$location =  "БОМЖ";
$num_insurance =  0;
$company = "Нет сведений";


 if (
 isset($_POST['l_name'])&&
 isset($_POST['name'])&&
 isset($_POST['f_name'])&&
 isset($_POST['b_day'])&&
 isset($_POST['phone_num'])&&
 isset($_POST['location'])&&
 isset($_POST['num_insurance'])&&
 isset($_POST['company'])
) {
     $l_name = htmlentities(mysqli_real_escape_string($link, $_POST['l_name']));
     $name = htmlentities(mysqli_real_escape_string($link, $_POST['name']));
     $f_name = htmlentities(mysqli_real_escape_string($link, $_POST['f_name']));
     $b_day = htmlentities(mysqli_real_escape_string($link, $_POST['b_day']));
     $phone_num = htmlentities(mysqli_real_escape_string($link, $_POST['phone_num']));
     $location = htmlentities(mysqli_real_escape_string($link, $_POST['location']));
     $num_insurance = htmlentities(mysqli_real_escape_string($link, $_POST['num_insurance']));
     $company = htmlentities(mysqli_real_escape_string($link, $_POST['company']));
 }

//  Необязательные для ввода поля.
$issue_date   = date('Y/m/d');
$last_visit   = date('Y/m/d');
$self_life    = 0;
$last_illness = "";
$last_counts  = 0;

if ( isset($_POST['last_visit'])  ) {     $last_visit = htmlentities(mysqli_real_escape_string($link, $_POST['last_visit'])); }
if ( isset($_POST['issue_date'])  ) {     $issue_date = htmlentities(mysqli_real_escape_string($link, $_POST['issue_date'])); }
if ( isset($_POST['self_life'])  ) {      $self_life = htmlentities(mysqli_real_escape_string($link, $_POST['self_life'])); }
if ( isset($_POST['last_illness'])  ) {   $last_illness = htmlentities(mysqli_real_escape_string($link, $_POST['last_illness'])); }
if ( isset($_POST['last_counts'])  ) {    $last_counts = htmlentities(mysqli_real_escape_string($link, $_POST['last_counts'])); }


// Проверка номера тефона на унимкальность
// ГО провериим пользоватея с такими же ФИО и датой рождения
// Проверка номера полиса на уникальность


// 1) Выполняем проверки и после этого всего создаём
//  2) Мед карта
//  3) Старховой полис
//  4) Пользовательские данные

// И всё это подчиняется одному ключу, если где-то не устраивает, то записываем в  него 0
// А елси всё нормально, то останется 1 и после



$rows = 1000;
$query = "SELECT * FROM `patients` WHERE phone_numb='$phone_num'";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
$rows = mysqli_num_rows($result); // Вернёт количество полученных строк

if ($rows != 0 ){
    $reg_errors .= "Пользователь с таким номером уже существует; ";
    $key = 0;
}



$query = "SELECT * FROM `patients` WHERE name='$name' AND last_name='$l_name' AND fathers_name='$f_name' AND birthday='$b_day'";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
$rows = mysqli_num_rows($result); // Вернёт количество полученных строк

if ($rows != 0 ){
    $reg_errors .= "Пользователь с такими ФИО и датой рождения уже существует; ";
    $key = 0;
}



$query = "SELECT * FROM `health_insurance` WHERE num_insurance='$num_insurance'";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
$rows = mysqli_num_rows($result); // Вернёт количество полученных строк

if ($rows != 0 ){
    $reg_errors .= "Пользователь с таким полисом уже существует; ";
    $key = 0;
}


if ($key != 0){
    // Создание мед карты
    $query = "INSERT INTO `med_card`(`illness`, `num_visits`) VALUES ('$last_illness', '$last_counts')";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    $result= mysqli_query($link, "SELECT MAX(id) FROM `med_card`") or die("Ошибка " . mysqli_error($link));
    $row=mysqli_fetch_assoc($result);
    $id_card = $row['MAX(id)'];



    // Создание полиса в таблице
    $query = "INSERT INTO `health_insurance`(`num_insurance`, `company`, `date of issue`, `shelf_life`) VALUES ('$num_insurance', '$company', '$issue_date', '$self_life')";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    $result = mysqli_query($link, "SELECT MAX(id) FROM `health_insurance`") or die("Ошибка " . mysqli_error($link));
    $row=mysqli_fetch_assoc($result);
    $id_insurance = $row['MAX(id)'];


    // Создание учётной записи пациента
    $query = "INSERT INTO `patients`(`name`, `last_name`, `fathers_name`, `birthday`, `phone_numb`, `location`, `last_visit`, `med_card_id`, `health_insurance_id`) 
VALUES ('$name', '$l_name', '$f_name', '$b_day', '$phone_num', '$location', '$last_visit', '$id_card', '$id_insurance')";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    if($result)
    {
        echo "Данные успешно добавлены";

    }

}

if ($key == 0){
    echo $reg_errors;
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