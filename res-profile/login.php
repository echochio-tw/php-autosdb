<?php
session_start();
require_once "pdo.php";

if (isset($_POST['cancel'])) {
  if ($_POST['cancel'] == "Cancel") {
    echo 'logout ....';
    header( "Location: logout.php", true, 301 );
    return;
  }
}
if (isset($_POST['email']) && isset($_POST['pass']) ){
if ( $_POST['email'] != '' &&  $_POST['pass'] != '') {
    $_SESSION['login'] = 'login';
    $_SESSION['id_email'] = $_POST['email'];
    $_SESSION['id_pass'] = $_POST['pass'];
    error_log("Get POST Login info ".$_SESSION['id_email']);
    header( "Location: login.php", true, 301 );
    return;
}
}

if (isset($_SESSION['login'])){
    unset($_SESSION['login']);
    $salt='XyZzy12*_';
    $check = hash('md5', $salt.$_SESSION['id_pass']);    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE password = :pw AND email = :id_email");
    $stmt->execute(array(':pw' => $check,':id_email' => $_SESSION['id_email']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === FALSE){
      error_log("Login fail ".$_SESSION['id_email']." $check");
      $_SESSION['error'] = 'Incorrect password';
      unset($_SESSION['id_email']);
      unset($_SESSION['id_pass']);
    } else {
      $_SESSION["user_name"] = $row['name'];
      error_log("Login success ".$_SESSION['id_email']);
      echo "<p>Login success.</p>\n";
      $_SESSION['user_id']=$row['user_id'];
      //echo $_SESSION['id_email'];
      //echo $_SESSION['id_pass'];
      unset($_SESSION["error"]);
      header( "Location: index.php", true, 301 );
      return;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Echochio Login Page 9ada6f78</title>
<script>
function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('id_1723').value;
        console.log("Validating addr="+addr+" pw="+pw);
        if (addr == null || addr == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if ( addr.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
<form id="loginform" method="POST">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a id_password hint, view source and find a id_password hint
in the HTML comments.
<!-- Hint: The id_password is the three character name of the
programming language used in this class (all lower case)
followed by 123. -->
</p>
</div>
</body>

