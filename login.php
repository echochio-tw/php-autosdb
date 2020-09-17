<?php
session_start();
require_once "pdo.php";

if ($_POST) {
  if (isset($_POST['cancel'])) {
    if ($_POST['cancel'] == "Cancel") {
      $_SESSION['logout'] = 'logout';
    }
  }

  if ( isset($_POST['email']) && isset($_POST['pass'])  ) {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['pass'] = $_POST['pass'];
    header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
  }
  header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
}

if (isset($_SESSION['logout'])){
  header( "Location: logout.php", true, 303 );
}

if (isset($_SESSION['email']) && isset($_SESSION['pass'])){
  if ($_SESSION['email'] == "") {
    $_SESSION["error"] = 'Email and password are required';
  } elseif ($_SESSION['pass'] == "") {
    $_SESSION["error"] = 'Email and password are required';
  } elseif ((strpos($_SESSION['email'], '@') == false)) {
    $_SESSION["error"] = 'account without an at-sign (@)';
  } else {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE password = :pw");
    $stmt->execute(array(':pw' => $_SESSION['pass']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === FALSE){
      $check = password_hash($_SESSION['pass'], PASSWORD_DEFAULT);
      error_log("Login fail ".$_SESSION['email']." $check");
      $_SESSION['error'] = '<p style="color: red;">Incorrect password</p>';
    } else {
      error_log("Login success ".$_SESSION['email']);
      echo "<p>Login success.</p>\n";
      echo $_SESSION['email'];
      echo $_SESSION['pass'];
      unset($_SESSION["error"]);
      header('HTTP/1.1 301 Moved Permanently');
      header("Location: view.php");
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Echochio Login Page 80de80d9</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php 
if ( isset($_SESSION["error"]) ) {
  echo('<p style="color: red;">'.$_SESSION["error"].'</p>');
  // unset($_SESSION["error"]);
}
?>
<form method="POST" action="login.php">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find an account and password hint
in the HTML comments.
<!-- Hint:
The account is csev@umich.edu
The password is the three character name of the
programming language used in this class (all lower case)
followed by 123. -->
</p>
</div>
</body>
