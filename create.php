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
				<h1>Add User</h1>
				<form name="add-user" action="check.php" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="">Username</label>
						<input type="text" name="name" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="">Email</label>
						<input type="email" name="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="">Password</label>
						<input type="password" name="password" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="">Added photo</label>
						<input type="file" name="photo" class="form-control">
					</div>
					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>