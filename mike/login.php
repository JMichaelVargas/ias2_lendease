<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
    <!-- FONTAWESOME CSS ICON-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style1.css">
    <title>Login</title>
</head>
<body>
<div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Account Login</h2>
                <form action="" method="post" autocomplete="off">
                    <div class="mb-3">
                        <label for="usernameemail" class="form-label">Username or Email:</label>
                        <input type="text" class="form-control" name="usernameemail" id="usernameemail" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                        <label class="form-label" for="showPasswordCheckbox">Show Password</label>
                        <input type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()"><br><br>
                    </div>
                    <div class="text-center">
                        <a href="forgot_password.php">Forgot your password? Click here</a>
                    </div><br>
                    <button type="submit" class="btn btn-primary" name="submit">Login</button>
                    <span>Don't have an account? <a href="signup.php">Register here</a></span>
                </form>
            </div>
        </div>
    </div>                                                                                              
    <?php
    if(isset($_POST['submit'])){
        require '_dbcon.php';
        $usernameemail = $_POST['usernameemail'];
        $password = $_POST['password']; // Add isset() check here

        // Use prepared statements to prevent SQL injection
        $stmt = $connect->prepare("SELECT * FROM vargas_johnmichael WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameemail, $usernameemail);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row) {
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];
                header("location: index.html");
            } else {
                echo "<script>alert('Incorrect Password');</script>";
            }
        } else {
            echo "<script>alert('User not Registered');</script>";
        }

        $stmt->close();
        $connect->close();
    }
    ?>        
    <script src="js/main.js"></script>
</body>
</html>
