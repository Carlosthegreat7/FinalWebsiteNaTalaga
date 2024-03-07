<?php

session_start();

include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($password)) {

        $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION["loggedin"] = true;
            $_SESSION["user_id"] = $user['id'];
            $_SESSION["email"] = $email;

            header("location: feedbacks.php");

            exit;
        } else {

            $error_message = "The email or password you entered was not valid.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head> 
<body>

    <div class ="panel">
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="feedbacks.php">Feedbacks</a></li>
        </ul>
    </nav>
    </div>

    <div class="transparent-box">
        <div class="container">
            <form action="login.php" method="post">
                <div class="form-group">
                    <h1>Login</h1>
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>

                <p>No Account?<a href="registration.php">Click Here!</a></p>

            </form>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    


    
</body>
</html>
