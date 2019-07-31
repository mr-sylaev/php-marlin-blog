<?php
    $name                = $_POST['name'];
    $email               = $_POST['email'];
    $password            = $_POST['password'];
    $heshPassword        = md5($password."ras123ras");
    $userPhoto           = $_FILES['photo'];
    $randomNameUserPhoto = mt_rand(74573773, 999193195).$userPhoto['name'];
    $pathUpload          = "../uploads/"; // Директория файлов
    $users_emails        = []; // Здесь будем хранить все почты пользователей, для проверки на раннее существующей почты


    // Подключение к БД
    try {
        $connection = new PDO('mysql:host=localhost;dbname=php-marlin-blog;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage();
        die();
    }

    // Отправка запраса в БД на добавление новой записи
    $statement = $connection->query("SELECT * FROM `users`");
    $users = $statement->fetchAll();
    $statement->connection = null;


    // Добавляю все почты пользлвателлей в массив $users_emails
    foreach ($users as $user) {
        array_push($users_emails, $user['email']);
    }


    // Функция Ссылка на изменение значения поля, срабатывает в случае ошибки
    function btnRenameInput () {
        echo "<br><a href='../register.php'>Исправить ошибку</a>";
    }


    // Проверка на валидность имени
    if ($name == "" || strlen($name) < 3) {
        echo "Имя должно содержать минимум 3 символа";
        btnRenameInput();
    }
    // Проверка на валидность почты
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Неправильна указана почта";
        btnRenameInput();
    }
    // Проверка существует ли пользователь с такой почтой
    else if (in_array($email, $users_emails)) {
        echo "Пользователь с такой почтой уже существует. \n Введите другую почту.";
        btnRenameInput();
    }
    // Проверка на валидность пароля
    else if ($password == "" || strlen($password) < 8) {
        echo "Пороль должен состоять минимум из 8 символов";
        btnRenameInput();
    }
    // Если поля имя, почта и пароль валидны, то загружаем фотографию пользователя
    else {
        // Проверяем метод запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Если картинка (файл) загружена
            if (@copy($userPhoto['tmp_name'], $pathUpload . $randomNameUserPhoto)) {
                // Подключение к БД
                try {
                    $connection = new PDO('mysql:host=localhost;dbname=php-marlin-blog;charset=utf8', 'root', '');
                } catch (PDOException $e) {
                    print "Error!: " . $e->getMessage();
                    die();
                }

                // Отправка запраса в БД на добавление новой записи
                $statement = $connection->query("INSERT INTO `users` (`name`, `email`, `password`, `user_photo`) VALUES ('$name', '$email','$heshPassword', '$randomNameUserPhoto') ");
                $statement->connection = null;


                header("Location: /login.php");
            }
            // Если картинка (файл) не загружена
            else {
                // Подключение к БД
                try {
                    $connection = new PDO('mysql:host=localhost;dbname=php-marlin-blog;charset=utf8', 'root', '');
                } catch (PDOException $e) {
                    print "Error!: " . $e->getMessage();
                    die();
                }

                // Отправка запраса в БД на добавление новой записи
                $statement = $connection->query("INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name', '$email','$heshPassword') ");
                $statement->execute();
                $statement->connection = null;


                header("Location: /login.php");
            }
        }
    }
?>