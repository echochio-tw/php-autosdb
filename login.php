<?php
require_once "pdo.php";

$error = '';

// p' OR '1' = '1

if ( isset($_POST['who']) && isset($_POST['pass'])  ) {
    $sql = "SELECT * FROM users WHERE password = :pw";
    $who =  $_POST['who'];
    $pw =  $_POST['pass'];
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':pw' => $_POST['pass']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
   if ($who == "") {
     $error = '<p style="color: red;">User name and password are required</p>';
   } elseif ($pw == "") {
     $error = '<p style="color: red;">User name and password are required</p>';
   } elseif ((strpos($who, '@') == false)) {
     $error = '<p style="color: red;">who must have an at-sign (@)</p>';
   } elseif ( $row === FALSE ) {
     $check = password_hash($pw, PASSWORD_DEFAULT);
     error_log("Login fail ".$who." $check");
     $error = '<p style="color: red;">Incorrect password</p>';
   } else {
      error_log("Login success ".$who);
      echo "<p>Login success.</p>\n";
      header('HTTP/1.1 301 Moved Permanently');
      header("Location: autos.php?name=".urlencode($_POST['who']));
      exit();
   }
}
?>
<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<title>Echochio Login Page 25315d7e</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php echo $error; ?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id">Password</label>
<input type="text" name="pass"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
</p>
</div>
</body>
