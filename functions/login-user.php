<?php
    session_start();

    $id                  = null;
    $name                = null;
    $email               = $_POST['email'];
    $password            = $_POST['password'];
    $checkbox_remember   = $_POST['checkbox_remember'];
    $userPhoto           = null;
    $hashPassword        = md5($password."ras123ras");
    $validateUser        = null;

    // Функция Ссылка на изменение значения поля, срабатывает в случае ошибки
    function btnRenameInput () {
        echo "<br><a href='../login.php'>Вернуться назад</a>";
    }


    // Проверка на валидность почты
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Неправильна указана почта";
        btnRenameInput();
        exit();
    }
    // Проверка на валидность пароля
    else if ($password == "" || strlen($password) < 8) {
        echo "Пороль должен состоять минимум из 8 символов";
        btnRenameInput();
        exit();
    }


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
        if ($email == $user['email'] && $hashPassword == $user['password']) {
            $validateUser = 1;
            $id = $user['id'];
            $name = $user['name'];
            $userPhoto = $user['user_photo'];


            $user_data = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'hashPassword' => $hashPassword,
                'password' => $password,
                'photo' => $userPhoto,
            ];
        }
    }

    // Если введенные данные не совподают с данными в БД, то выводим ошибку
    if ($validateUser == 0) {
        echo "Неправильно указаны данные";
        btnRenameInput();
        exit();
    }


    // Если не была установлена галочка "Запомнить меня",
    if ($checkbox_remember == ''){
        $_SESSION['user_data'] = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'hashPassword' => $hashPassword,
            'password' => $password,
            'photo' => $userPhoto,
        ];

        // Удаляем выбранные куки
        setcookie('user_email', $user_data['email'], time() - 1296000, "/");
        setcookie('user_email', $user_data['email'], time() + 1296000, "/login.php");
        setcookie('user_hashPassword', $user_data['hashPassword'], time() - 1296000, "/");
        setcookie('user_password', $user_data['password'], time() - 1296000, "/login.php");

        header("Location: /");
    }

    // Если была установлена галочка Запомнить меня
    if ($checkbox_remember == 'on'){
        $_SESSION['user_data'] = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'hashPassword' => $hashPassword,
            'password' => $password,
            'photo' => $userPhoto,
        ];

        // Создаем необходимые куки
        setcookie('user_email', $user_data['email'], time() + 1296000, "/");
        setcookie('user_email', $user_data['email'], time() + 1296000, "/login.php");
        setcookie('user_hashPassword', $user_data['hashPassword'], time() + 1296000, "/");
        setcookie('user_password', $user_data['password'], time() + 1296000, "/");

        header("Location: /");
    }
?>