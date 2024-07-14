<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <title>Forgot Password</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Reset Password</h2>
                <form action="" method="post">
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
