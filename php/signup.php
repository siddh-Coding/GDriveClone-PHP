<html>

<head>
  <title>Create Account - FileHub</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <div class="wrapper">
    <section class="form signup">
      <h1>FileHub - Create Account</h1>
      <form method="POST">
        <div id="error_text">
          <?php
          session_start();
          include 'db.php';
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['pass'])) {
              $fname = $_POST['fname'];
              $lname = $_POST['lname'];
              $email = $_POST['email'];
              $pass = $_POST['pass'];


              if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (strlen($pass) < 8) {
                  echo "<style> #error_text{display: block;} </style>";
                  echo "Your password Length : " . strlen($pass);
                  echo "<br>Your password should be at least 8 characters long.";
                } else {
                  //If all data are correct
                  $sqlquery = "INSERT INTO users(fname,lname, email, pass) VALUES('$fname','$lname', '$email', '$pass')";
                  if ($conn->query($sqlquery) === true) {
                    $sql2 = "SELECT id FROM users WHERE email='$email'";
                    $result2 = $conn->query($sql2);
                    // if ($conn->query($sql2) === true) {
                    $row = $result2->fetch_assoc();
                    $id = $row['id'];
                    setcookie('user_id', $id, time() + (30 * 24 * 60 * 60));
                    setcookie('user_email', $email, time() + (30 * 24 * 60 * 60));
                    // $user_id = $id;
                    $user_uploads_dir = __DIR__ . "/uploads/" . $id;
                    if (!file_exists($user_uploads_dir)) {
                      mkdir($user_uploads_dir, 0777, true);
                    }
                    // }
                    header("Location: php/index.php");
                    exit();
                  }
                  //If error in DATABASE or SQL query 
                  else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                  }

                }
              } else {
                echo "<style> #error_text{display: block;} </style>";
                echo "Invalid Email";
              }
            }
          }
          ?>

        </div>
        <div class="name-details">
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" placeholder="First name" required>
          </div>
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="Last name" required>
          </div>
        </div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="pass" placeholder="Enter password" required>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Create account">
        </div>
      </form>
      <div class="link">Already signed up? <a href="../index.php">Login now</a></div>
    </section>
  </div>


</body>

</html>