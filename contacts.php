<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Обслуживание</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

    <?php
    session_start();
    // session_unset();
    // session_destroy();
    ?>

    <div id="header">
        <h1>Поликлиника №100500</h1>
        <div id="nav">
            <ul>
                <li><a href="index.php">Главная</a></li>
            </ul>
        </div>
    </div>
    <div class="wrapper">
        <!--    ТО что будет в середине сайта-->
        <div id="article">
            <h1>Контакты</h1>
            <p> Телефон регистратуры: 8(965)-195-76-10</p>
            <p> Телефон дежурного врача: 8(965)-195-98-849</p><br><br>
            <p> Адрес: Москва, Мосфильмовская ул., 29А, 119330</p><br><br>
            <p>Электронная почта системного администртора: chyvak357@gmail.com</p>
            <a href="staff_main.php">Панель администрации</a>
        </div>
    </div>
    <div id="footer">
        <p>Contacts: chyvak357@gmail.com</p>
        <p>Copyright © MySyte.com, 2022</p>
    </div>
</body>

</html>