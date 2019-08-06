<?php
    session_start();
    session_destroy();

    $email               = $_POST['email'];
    $password            = $_POST['password'];
    $hashPassword        = md5($password."ras123ras");

    $user_data = [
        'email' => $email,
        'password' => $password,
        'hashPassword' => $hashPassword,
    ];

    setcookie('user_email', $user_data['email'], time() - 1296000, "/");
    setcookie('user_email', $user_data['email'], time() + 1296000, "/login.php");
    setcookie('user_hashPassword', $user_data['hashPassword'], time() - 1296000, "/");
    setcookie('user_password', $user_data['password'], time() - 1296000, "/login.php");

    header('Location: /');
?>