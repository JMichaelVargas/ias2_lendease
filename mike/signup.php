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
    <title>Signup</title>
    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var cpassword = document.getElementById("cpassword").value;
            var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/;

            if (!passwordRegex.test(password)) {
                alert("Password must be at least 8 characters long and include a mix of letters, numbers, and symbols.");
                return false;
            }
            if (password !== cpassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }

        function validateEmail() {
            var email = document.getElementById("email").value;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }
            return true;
        }

        function validateForm() {
            return validateEmail() && validatePassword();
        }
    </script>
</head>
<body>
<div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Create an Account</h2>
                <form action="" method="post" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="cpassword" id="cpassword" required>
                        <label class="form-label" for="showPasswordCheckbox">Show Password</label>
                        <input type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()"><br><br>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Signup</button>
                    <span>Already have an account? <a href="login.php" class="login">Login</a></span>
                </form>
            </div>
        </div>
    </div>                                                                                              
    <?php
        if(isset($_POST['submit'])){
            require '_dbcon.php';
            $name = $_POST['name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];

            // Server-side validation for password strength
            if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\'":\\|,.<>\/?]).{8,}$/', $password)) {
                echo "<script>alert('Password must be at least 8 characters long and include a mix of letters, numbers, and symbols.');</script>";
            } else {
                $duplicate = mysqli_query($connect, "SELECT * FROM vargas_johnmichael WHERE username = '$username' OR email = '$email'");

                if(mysqli_num_rows($duplicate) > 0){
                    echo "<script>alert('Username or Email has Already Exist');</script>";
                } else {
                    if($password == $cpassword){
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $query = "INSERT INTO vargas_johnmichael (name, username, email, password) VALUES ('$name', '$username', '$email', '$hashed_password')";
                        mysqli_query($connect, $query);
                        echo "<script>alert('Account Created!');</script>";
                    } else {
                        echo "<script>alert('Passwords do not match!');</script>";
                    }
                }
            }
        }
    ?>        
    <script src="js/main.js"></script>
</body>
</html>
