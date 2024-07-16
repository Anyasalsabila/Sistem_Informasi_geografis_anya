<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/signin.css">
</head>
<body>
    <div class="container">
        <?php
        session_start();
        if (isset($_SESSION['msg'])) {
            echo '<div class="alert alert-' . $_SESSION['msg_type'] . '" role="alert">' . $_SESSION['msg'] . '</div>';
            unset($_SESSION['msg']);
            unset($_SESSION['msg_type']);
        }
        ?>
        <form class="form-signin" action="proses_daftar.php" method="post">
            <h2 class="form-signin-heading">Sign Up</h2>
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
            <br>
            <p class="small mb-0">Already have an account? <a href="login.php">Sign In</a></p>
        </form>
    </div>
</body>
</html>
