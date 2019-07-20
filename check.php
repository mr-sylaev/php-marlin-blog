<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Обработка формы</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

    <?php
        $name                = $_POST['name'];
        $email               = $_POST['email'];
        $password            = $_POST['password'];
        $heshPassword        = md5($password)."c3b2a1";
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
        else if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
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


                    echo <<<HTML
                    <h1>Новая запись успешная создана!</h1>
                    <script>
                        setTimeout(function () {
                            window.location = "/";
                        }, 2500   );
                    </script>
HTML;
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


                    echo <<<HTML
                    <h1>Новая запись успешная создана!</h1>
                    <script>
                        setTimeout(function () {
                            window.location = "/";
                        }, 2500   );
                    </script> 
HTML;
                }
            }
        }
    ?>


</body>
</html>
