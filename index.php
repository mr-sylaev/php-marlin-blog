<?php
    try {
        $connection = new PDO('mysql:host=localhost;dbname=php-marlin-blog;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage();
        die();
    }

    // Отправляю запрос на выборку всех элементов из БД
    $statement = $connection->query("SELECT * FROM `users`");
    // Закрываю соединение с БД
    $statement->connection = null;
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
			<div class="col-md-12">
				<h1>User management</h1>
				<a href="create.php" class="btn btn-success">Add User</a>
				
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Username</th>
							<th>Email</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>
                        <?php foreach ($statement as $user) : ?>
                        <tr>
                            <td><?=$user['id'];?></td>
                            <td><?=$user['name'];?></td>
                            <td><?=$user['email'];?></td>
                            <td>
                                <a href="edit.php<?='/?id='.$user['id']?>" class="btn btn-warning" onclick="">Edit</a>
                                <a href="delete-user.php<?='/?id='.$user['id']?>" onclick="return confirm('are you sure?');" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>