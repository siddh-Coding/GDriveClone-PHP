<!DOCTYPE html>
<?php
// session_start();
// if (isset($_COOKIE['user_email'])) {
//   header('Location:home.php');
//   exit();
// }
// ?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FileHub</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="wrapper">
    <section class="form" aria-labelledby="formHeader" aria-describedby="formInfo">
      <h1 id="formHeader">FileHub - Login</h1>
      <form method="POST" action=<?php $_SERVER['PHP_SELF'] ?>>
        <div id="error_text" class="error-text">
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['email']) && !empty($_POST['pass'])) {
              include 'php/db.php';
              $email = $conn->real_escape_string($_POST['email']);
              $pass = $conn->real_escape_string($_POST['pass']);

              $sql = "SELECT * FROM users WHERE email='$email' AND pass='$pass'";
              $result = $conn->query($sql);

              if ($result->num_rows == 1) {
                $sql2 = "SELECT id FROM users WHERE email='$email'";
                $result2 = $conn->query($sql2);
                $row = $result2->fetch_assoc();
                $id = $row['id'];
                setcookie('user_id', $id, time() + (30 * 24 * 60 * 60));
                setcookie('user_email', $email, time() + (30 * 24 * 60 * 60)); // 30 days expiration
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                header("Location: php/home.php?list=home");
                exit();
              } else {
                echo "<style>#error_text{display: block;}</style>";
                echo "Incorrect email or password";
              }
            }
          }
          ?>
        </div>

        <div class="field input">
          <label for="email">Email Address</label>
          <input id="email" type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="field input">
          <label for="password">Password</label>
          <input id="password" type="password" name="pass" placeholder="Enter your password" required>
        </div>

        <div class="field button">
          <input type="submit" name="submit" value="Login">
        </div>
      </form>
      <p id="formInfo" class="link">Not yet signed up? <a href="php/signup.php">Signup now</a></p>
    </section>
  </div>

</body>



</html>