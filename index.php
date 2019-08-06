<?php
    session_start();

    // Если Сессии 'user_data' не существует
    if ( !isset($_SESSION['user_data']) ) {
        // Если Куки 'user_email' и 'user_hashPassword' существуют
        if ( isset($_COOKIE['user_email']) && isset($_COOKIE['user_hashPassword']) ) {
            // Подключение к БД
            try {
                $connection = new PDO('mysql:host=localhost;dbname=php-marlin-blog;charset=utf8', 'root', '');
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage();
                die();
            }

            // Отправка запраса в БД на получение всех значений
            $statement = $connection->query("SELECT * FROM `users`");
            $users = $statement->fetchAll();
            $statement->connection = null;


            // Проверка на совподение введенных данных для входа с данными в БД
            foreach ($users as $user) {
                // Если введенные данные совподают с данными в БД, в переменной $validateUser меняем значение с 0 на 1
                if ($_COOKIE['user_email'] == $user['email'] && $_COOKIE['user_hashPassword'] == $user['password']) {
                    $id = $user['id'];
                    $name = $user['name'];
                    $userPhoto = $user['user_photo'];

                    $_SESSION['user_data'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'hashPassword' => $user['hashPassword'],
                        'photo' => $user['user_photo'],
                    ];
                }
            }
        }
        // Если Куки 'user_email' и 'user_hashPassword' не существуют, то происходит переадресации на страницу login.php
        else{
            header("Location: /login.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <? if ( !isset($_SESSION['user_data']['email']) && !isset($_SESSION['user_data']['hashPassword']) ) : ?>
    <div class="row">
        <div class="col-md-6 mt-3">
            <a href="login.php" class="btn btn-success">Login</a>
            <a href="register.php" class="btn btn-danger">Register</a>
        </div>
    </div>
    <? else : ?>
        <div class="row">
            <h2>Welcome, <?=$_SESSION['user_data']['name']?></h2>
            <br>
            <a href="/exit.php">Выйти</a>
        </div>
    <? endif; ?>
</div>
</body>
</html>
