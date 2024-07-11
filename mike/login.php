<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/signup1.css">
    <title>Login</title>
</head>

<body>
<div class="container">
        <div class="card">
            <div class="card-body">
            <i class="fa-sharp fa-solid fa-graduation-cap"></i><h1>JMV</h1><br>
                <h2 class="card-title">Account Login</h2>
                <form action="" method="post" autocomplete="off">
                    <div class="mb-3">
                        <label for="usernameemail" class="form-label">Username or Email:</label>
                        <input type="text" class="form-control" name="usernameemail" id="usernameemail" required value="">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" required value="">
                        <label class="form-label" for="showPasswordCheckbox">Show Password</label>
                        <input type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()"><br><br>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Login</button>
                    <span>Don't have an account? <a href="signup.php">Register here</a></span>
                </form>
            </div>
        </div>
    <?php
    if (isset($_POST['submit'])) {
        require '_dbcon.php';
        $usernameemail = $_POST['usernameemail'];
        $password = $_POST['password']; // add isset() check here
        $result = mysqli_query($connect, "SELECT * FROM vargas_johnmichael WHERE username = '$usernameemail' OR email = '$usernameemail'");
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) > 0) {
            if (!empty($row) && $password == $row['password']) {
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];
                header("location: index.html");
            } else {
                echo "<script>alert('Incorrect Password');</script>";
            }
        } else {
            echo "<script>alert('User not Registered');</script>";
        }
    }
    ?>
    <script src="js\main.js"></script>
</body>
</html>