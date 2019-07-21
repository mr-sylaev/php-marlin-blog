<?php
    $name                = $_POST['name'];
    $email               = $_POST['email'];
    $password            = $_POST['password'];
    $heshPassword        = md5($password."ras123ras");
    $userPhoto           = $_FILES['photo'];
    $randomNameUserPhoto = mt_rand(74573773, 999193195).$userPhoto['name'];
    $pathUpload          = "uploads/"; // Директория файлов

    // Функция Ссылка на изменение значения поля, срабатывает в случае ошибки
    function btnRenameInput () {
        echo "<br><a href='create.php'>Исправить ошибку</a>";
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


                header("Location: /");
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
                $statement->connection = null;


                header("Location: /");
            }
        }
    }
?>