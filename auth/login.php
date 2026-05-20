<?php

session_start();

include("../config/db.php");

if(isset($_POST['login'])) {

    $email = $_POST['email'];

    $password = $_POST['password'];

    $query = "

    SELECT *

    FROM users

    WHERE email = '$email'

    AND password = '$password'

    ";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['user_id'];

        $_SESSION['name'] = $user['name'];

        $_SESSION['role'] = $user['role'];

        header("Location:../dashboard/index.php");

    } else {

        $error = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Login</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center">

<div class="col-md-4">

<div class="card shadow mt-5">

<div class="card-header bg-dark text-white">

<h3 class="text-center">

DMRC Login

</h3>

</div>

<div class="card-body">

<?php if(isset($error)) { ?>

<div class="alert alert-danger">

<?php echo $error; ?>

</div>

<?php } ?>

<form method="POST">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

<br>

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

<br>

<button
type="submit"
name="login"
class="btn btn-primary w-100">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>