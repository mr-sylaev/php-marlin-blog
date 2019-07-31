<?php
    $id                  = $_POST['id'];
    $name                = $_POST['name'];
    $email               = $_POST['email'];
    $password            = $_POST['password'];
    $heshPassword        = md5($password."ras123ras");
    $userPhoto           = $_FILES['photo'];
    $randomNameUserPhoto = mt_rand(74573773, 999193195).$userPhoto['name'];
    $pathUpload          = "uploads/"; // Директория файлов

    // Функция Ссылка на изменение значения поля, срабатывает в случае ошибки
    function btnRenameInput () {
        $id = $GLOBALS["id"];
        echo "<br><a href="."../edit.php/?id=$id".">Исправить ошибку</a>";
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

                // Подключаемся к БД
                try {
                    $connection = new PDO('mysql:host=localhost;dbname=php-marlin-blog;charset=utf8', 'root', '');
                } catch (PDOException $e) {
                    print "Error!: " . $e->getMessage();
                    die();
                }

                // Получаем название старой фотки пользователя
                $statement = $connection->pprepare("SELECT user_photo FROM `users` WHERE id = :id");
                $statement->bindParam(":id" ,$id);
                $statement->execute();
                $OldUserPhoto = $statement->fetchColumn();

                // Удаляем страую фотку пользователя
                unlink($pathUpload.$OldUserPhoto);

                // Отправка запраса в БД на редактирование записи по указанному ID
                $statement = $connection->query("UPDATE users SET name = '$name', email = '$email', password= '$heshPassword', user_photo = '$randomNameUserPhoto' WHERE id = '$id'");
                $statement->connection = null;

                header("Location: /admin/");
            }
            // Если картинка (файл) не загружена
            else {

                // Подключаемся к БД
                try {
                    $connection = new PDO('mysql:host=localhost;dbname=php-marlin-blog;charset=utf8', 'root', '');
                } catch (PDOException $e) {
                    print "Error!: " . $e->getMessage();
                    die();
                }

                // Отправка запраса в БД на редактирование записи по указанному ID
                $statement = $connection->query("UPDATE users SET name = '$name', email = '$email', password= '$heshPassword' WHERE id = '$id'");
                $statement->connection = null;

                header("Location: /admin/");
            }
        }
    }
?>