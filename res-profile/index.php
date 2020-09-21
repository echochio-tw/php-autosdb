<?php
    session_start();
    require_once "pdo.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Echochio Severance's Resume Registry 9ada6f78</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Echochio Severance's Resume Registry</h1>
<?php
  // Check if we are logged in!
  echo '<p><a href="logout.php">Logout</a></p>';
  if ((! isset($_SESSION["id_email"]) && ! isset($_SESSION["id_pass"])) ) { 
    echo '<p><a href="login.php">Please log in</a></p>';
    $stmt = $pdo->query("SELECT first_name, last_name, headline, profile_id, `user_id` FROM `Profile`");
    if ($stmt->rowCount(PDO::FETCH_ASSOC) != 0){
      echo_stmt_function($stmt,0);
    }
  } else {
    $user_id = $_SESSION["user_id"];
    if (isset($_SESSION["error"])){
      echo $_SESSION["error"];
      unset($_SESSION["error"]);
    }
    $stmt = $pdo->query("SELECT first_name, last_name, headline, profile_id, `user_id` FROM `Profile`");
    if ($stmt->rowCount(PDO::FETCH_ASSOC) != 0){
      echo_stmt_function($stmt,$user_id);
    }
      echo '<p></p><p><a href="add.php">Add New Entry</a></p>';
  }
function echo_stmt_function($stmt,$ligin){
  echo('<table border="1">');
  echo ('<tr><th>Name</th><th>Headline</th><th>Action</th><tr>');
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    //echo '<a href="view.php?profile_id='.$row['profile_id'].'>';
    echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.$row['first_name'].' '.$row['last_name'].'</a>');
    //echo '</a>';
    echo("</td><td>");
    echo($row['headline']);
    echo("</td><td>");
    if ($ligin == $row['user_id']){
      echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
      echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    }
    echo("</td></tr>\n");
    echo('<p></p>');
  }
  echo '</table>';
  return ;
}
?>
<p>
<p></p>
<b>Note:</b> Your implementation should retain data across multiple
logout/login sessions.  This sample implementation clears all its
data periodically - which you should not do in your implementation.
</p>
</div>