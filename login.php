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
            <h1>Login</h1>
            <form name="login_user" action="/functions/login-user.php" method="POST">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>