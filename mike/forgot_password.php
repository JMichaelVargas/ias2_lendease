<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <title>Forgot Password</title>
    <script>
        function validatePassword() {
            var newpassword = document.getElementById("newpassword").value;
            var cnewpassword = document.getElementById("cnewpassword").value;
            var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/;

            if (!passwordRegex.test(newpassword)) {
                alert("Password must be at least 8 characters long and include a mix of letters, numbers, and symbols.");
                return false;
            }
            if (newpassword !== cnewpassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }

        function togglePasswordVisibility() {
            var newpassword = document.getElementById("newpassword");
            var cnewpassword = document.getElementById("cnewpassword");
            if (newpassword.type === "password" && cnewpassword.type === "password") {
                newpassword.type = "text";
                cnewpassword.type = "text";
            } else {
                newpassword.type = "password";
                cnewpassword.type = "password";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Reset Password</h2>
                <form action="" method="post" onsubmit="return validatePassword()">
                    <div class="mb-3">
                        <label for="usernameemail" class="form-label">Username or Email</label>
                        <input type="text" class="form-control" name="usernameemail" id="usernameemail" required>
                    </div>
                    <div class="mb-3">
                        <label for="newpassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" name="newpassword" id="newpassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="cnewpassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="cnewpassword" id="cnewpassword" required>
                        <label class="form-label" for="showPasswordCheckbox">Show Password</label>
                        <input type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()"><br><br>
                    </div>
                    <button type="submit" class="btn btn-primary" name="reset">Reset Password</button>
                    <span>Back to <a href="login.php" class="login">Login</a></span>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['reset'])) {
        require '_dbcon.php';
        $usernameemail = $_POST['usernameemail'];
        $newpassword = $_POST['newpassword'];
        $cnewpassword = $_POST['cnewpassword'];

        // Check if username or email exists
        $stmt = $connect->prepare("SELECT * FROM vargas_johnmichael WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameemail, $usernameemail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "<script>alert('Username or Email not found');</script>";
        } else {
            if ($newpassword === $cnewpassword) {
                $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);

                // Use prepared statements to update the password
                $stmt = $connect->prepare("UPDATE vargas_johnmichael SET password = ? WHERE username = ? OR email = ?");
                $stmt->bind_param("sss", $hashed_password, $usernameemail, $usernameemail);

                if ($stmt->execute()) {
                    echo "<script>alert('Password reset successful!'); window.location.href='login.php';</script>";
                } else {
                    echo "<script>alert('Error: Could not reset password');</script>";
                }
            } else {
                echo "<script>alert('Passwords do not match');</script>";
            }
        }

        $stmt->close();
        $connect->close();
    }
    ?>
</body>
</html>
