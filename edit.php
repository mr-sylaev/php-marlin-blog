<?php
    if (isset($_GET['id'])) {
        // Подключаемся к БД
        try {
            $connection = new PDO('mysql:host=localhost;dbname=php-marlin-blog;charset=utf8', 'root', '');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }

        $userID = $_GET['id'];

        // Отправляю запрос на выборку всех элементов из БД
        $statement = $connection->query("SELECT * FROM `users` WHERE id=".$userID);

        $user = $statement->fetch();

        // Закрываю соединение с БД
        $statement->connection = null;
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
		<div class="row">
			<div class="col-md-6">
                <?php
                    if ($userID == $user['id']) {
                        echo "<h1>Edit User ID " . $user['id'] . "</h1>";
                    }
                    else {
                        echo "<h1>User $userID does not exist</h1>";
                    }
                ?>
				<form action="../edit-check.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$user['id']?>">
                    <div class="form-group">
                        <label for="">Username</label>
						<input type="text" name="name" class="form-control" value="<?=$user['name']?>">
					</div>
					<div class="form-group">
						<label for="">Email</label>
						<input type="email" name="email" class="form-control" value="<?=$user['email']?>">
					</div>
					<div class="form-group">
						<label for="">Password</label>
						<input type="password" name="password" class="form-control">
					</div>
                    <div class="form-group">
                        <label for="">Added photo</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
					<div class="form-group">
						<button type="submit" class="btn btn-warning">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>