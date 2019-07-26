<?php
    $id         = $_GET['id'];  // ID пользователя
    $pathUpload = "uploads/";   // Директория файлов

    // Подключаемся к БД
    try {
        $connection = new PDO('mysql:host=localhost;dbname=php-marlin-blog;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage();
        die();
    }

    // Отправляю запрос на выборку всех элементов из БД
    $statement = $connection->prepare("SELECT * FROM `users` WHERE id = :id");
    $statement->bindParam(":id", $id);
    $statement->execute();
    $user = $statement->fetch();


    // Удаляем фотографию пользователя (если фотка есть) с дериктроии Uploads
    if ($user['user_photo'] != null) {
        unlink($pathUpload.$user['user_photo']);
    }

    // Отправляю запрос на удаление записей по указанному id из БД
    $statement = $connection->prepare("DELETE FROM `users` WHERE id = :id");
    $statement->bindParam(":id", $id);
    $statement->execute();

    // Закрываю соединение с БД
    $statement->connection = null;

    header("Location: /");
?>