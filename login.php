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
                    <?php if ( isset($_COOKIE['user_email']) ) : ?>
                        <input type="email" name="email" class="form-control" required value="<?=$_COOKIE['user_email']?>">
                    <?php else : ?>
                        <input type="email" name="email" class="form-control" required>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <?php if ( isset($_COOKIE['user_password']) ) : ?>
                        <input type="password" name="password" class="form-control" required value="<?=$_COOKIE['user_password']?>">
                    <?php else : ?>
                        <input type="password" name="password" class="form-control" required>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="remember">
                        <input type="checkbox" name="checkbox_remember" id="remember">
                        Remember me
                    </label>
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