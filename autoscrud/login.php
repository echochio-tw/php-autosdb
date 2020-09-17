<?php
session_start();
require_once "pdo.php";

if (isset($_POST['login'])) {
  if ($_POST['login'] == "Log In") {
    $_SESSION['login'] = 'login';
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['pass'] = $_POST['pass'];
    error_log("Get POST Login info ".$_SESSION['email']);
    header( "Location: login.php", true, 301 );
    return;
  }
}

if (isset($_SESSION['login'])){
  unset($_SESSION['login']);
  if ($_SESSION['email'] == "") {
    $_SESSION["error"] = 'Email and password are required';
    unset($_SESSION['email']);
    unset($_SESSION['pass']);
  } elseif ($_SESSION['pass'] == "") {
    $_SESSION["error"] = 'Email and password are required';
    unset($_SESSION['email']);
    unset($_SESSION['pass']);
  } else {    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE password = :pw AND emailaddr = :email");
    $stmt->execute(array(':pw' => $_SESSION['pass'],':email' => $_SESSION['email']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === FALSE){
      $check = password_hash($_SESSION['pass'], PASSWORD_DEFAULT);
      error_log("Login fail ".$_SESSION['email']." $check");
      $_SESSION['error'] = 'Incorrect password';
      unset($_SESSION['email']);
      unset($_SESSION['pass']);
    } else {
      error_log("Login success ".$_SESSION['email']);
      echo "<p>Login success.</p>\n";
      echo $_SESSION['email'];
      echo $_SESSION['pass'];
      unset($_SESSION["error"]);
      header( "Location: index.php", true, 301 );
      return;
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Echochio Login Page 7b923ff2</title>

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
  if (isset($_SESSION['error'])){
    echo('<p style="color: red;">'.$_SESSION["error"].'</p>');
  }
?>
<form method="POST" action="login.php">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" name="login" value="Log In">
<a href="logout.php">Cancel</a></p>
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the three character name of the
programming language used in this class (all lower case)
followed by 123. -->
</p>
</div>
</body>

