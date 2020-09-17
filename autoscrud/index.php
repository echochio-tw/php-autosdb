<?php
    session_start();
    require_once "pdo.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Echochio Index Page 7b923ff2</title>

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
<h2>Welcome to the Automobiles Database </h2>  
<?php
    // Check if we are logged in!
    if ((! isset($_SESSION["email"]) && ! isset($_SESSION["pass"])) ) { 
       echo '<p><a href="login.php">Please log in</a></p>';
       echo '<p>Attempt to <a href="add.php">add data</a> without logging in</p>';
    } else { 
        if (isset($_SESSION["error"])){
            echo $_SESSION["error"];
            unset($_SESSION["error"]);
        }
        echo('<table border="1">');
        $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
        if ($stmt->rowCount(PDO::FETCH_ASSOC) == 0){
           echo ('<p>No rows found</p>');
        } else {
          echo ('<thead><tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr></thead>');
          while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo "<tr><td>";
            echo(htmlentities($row['make']));
            echo("</td><td>");
            echo(htmlentities($row['model']));
            echo("</td><td>");
            echo(htmlentities($row['year']));
            echo("</td><td>");
            echo(htmlentities($row['mileage']));
            echo("</td><td>");
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
            echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
            echo("</td></tr>\n");
          }
          echo '</table>';
        }
        ?>
        <p></p>
        <p><a href="add.php">Add New Entry</a></p>
        <p><a href="logout.php">Logout</a></p>
<p>
<b>Note:</b> Your implementation should retain data across multiple 
logout/login sessions.  This sample implementation clears all its
data on logout - which you should not do in your implementation.
</p>
    <?php } ?>
