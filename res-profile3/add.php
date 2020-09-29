<?php
require_once "pdo.php";
session_start();

require_once "validate.php";

if (!isset($_SESSION['id_email'])) {
  die("ACCESS DENIED");
}

  if (isset($_POST['cancel'])) {
    if ($_POST['cancel'] == "Cancel") {
      $_SESSION['cancel'] = 'index';
      error_log("to index in post");
      header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
      return;
    }
  }

  if (isset($_SESSION['cancel'])) {
    unset($_SESSION["cancel"]);
    unset($_SESSION["error"]);
    error_log("to index in session");
    header( "Location: index.php", true, 303 );
    return;
  }

  if (isset($_POST['add'])) {
    if ($_POST['add'] == "Add") {
      error_log("in post Add");
      if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline'])  && isset($_POST['summary']) ){
        $a = validatePos();
        if (is_string($a)){
          $_SESSION['error'] = $a;
          return; 
        }
        $b =validateEdu();
        if (is_string($b)){
          $_SESSION['error'] = $b;
          return; 
        }
        error_log("in post Add".$_SESSION['eduschool1']);
        $_SESSION['first_name'] = htmlentities($_POST['first_name']);
        $_SESSION['last_name'] = htmlentities($_POST['last_name']);
        $_SESSION['email'] = htmlentities($_POST['email']);
        $_SESSION['headline'] = htmlentities($_POST['headline']);
        $_SESSION['summary'] = htmlentities($_POST['summary']);
        error_log("add post ".$_SESSION['email']);
        header( "Location: add.php", true, 303 );
        return;
      }
    }
  }

if (isset($_SESSION['first_name']) && isset($_SESSION['last_name']) && isset($_SESSION['email']) 
          && isset($_SESSION['headline']) && isset($_SESSION['summary'])) {
  $ui = $_SESSION['user_id'];
  $fn = $_SESSION['first_name'];
  $ln = $_SESSION['last_name'];
  $em = $_SESSION['email'];
  $he = $_SESSION['headline'];
  $su = $_SESSION['summary'];
  unset($_SESSION['first_name']);
  unset($_SESSION["last_name"]);
  unset($_SESSION["email"]);
  unset($_SESSION["headline"]);
  unset($_SESSION["summary"]);
  unset($_SESSION["error"]);
  if ( ($fn=='') || ($ln=='') || ($em=='') || ($he=='') || ($su=='') ) {      
      $_SESSION["error"] ='<p style="color: red;">All fields are required</p>';
    } elseif  (strpos($em, '@') == false) {
      $_SESSION["error"] = '<p style="color: red;">Email address must contain @</p>';
    } else{
    $stmt = $pdo->prepare('INSERT INTO Profile (`user_id`, first_name, last_name, email, headline, summary) VALUES ( :ui, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(':ui' => $ui, ':fn' => $fn, ':ln' => $ln, ':em' => $em, ':he' => $he, ':su' => $su));
    $profile_id = $pdo->lastInsertId();
    inserPositions($pdo, $profile_id);
    insertEducations($pdo, $profile_id);
    $_SESSION["error"] ='<p style="color: green;">Profile added </p>';
    header( "Location: index.php", true, 303 );
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<?  require_once "head-link.php"; ?>
</head>
<body>
<div class="container">
<?php
echo "<h1>Adding Profile for ".$_SESSION["user_name"]."</h1>";
// echo $_SESSION["id_email"];
echo '</a></h1>';
if (isset($_SESSION["error"]) ) {
  error_log("in html ".$_SESSION["error"]);
  echo($_SESSION["error"]);
}
?>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Email:
<input type="text" name="email" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"></textarea>
<p>
<p></p>
Education: <input type="Submit" id ="addEdu" value="+">
<div id="edu_fields">
</div>
Position: <input type="submit" id="addPos" value="+">
<div id="position_fields">
</div>
</p>
<p>
<input type="submit" name="add" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
<script>
countPos = 0;
countEdu = 0;
// http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript
$(document).ready(function(){
    window.console && console.log('Document ready called');

    $('#addPos').click(function(event){
        // http://api.jquery.com/event.preventdefault/
        event.preventDefault();
        if ( countPos >= 9 ) {
            alert("Maximum of nine position entries exceeded");
            return;
        }
        countPos++;
        window.console && console.log("Adding position "+countPos);

        $('#position_fields').append(
            '<div id="position'+countPos+'"> \
            <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
            <input type="button" value="-" \
                onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
            <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
    });

    $('#addEdu').click(function(event){
        event.preventDefault();
        if ( countEdu >= 9 ) {
            alert("Maximum of nine education entries exceeded");
            return;
        }
        countEdu++;
        window.console && console.log("Adding education "+countEdu);

        // Grab some HTML with hot spots and insert into the DOM
        var source  = $("#edu-template").html();
        $('#edu_fields').append(source.replace(/@COUNT@/g,countEdu));

        // Add the even handler to the new ones
        $('.school').autocomplete({
            source: "school.php"
        });

    });

    $('.school').autocomplete({
        source: "school.php"
    });

});

</script>
<!-- HTML with Substitution hot spots  16:59 -->
<script id="edu-template" type="text">
  <div id="edu@COUNT@">
    <p>Year: <input type="text" name="eduyear@COUNT@" value="" />
    <input type="button" value="-" onclick="$('#edu@COUNT@').remove();return false;"><br>
    <p>School: <input type="text" size="80" name="eduschool@COUNT@" class="school" value="" />
    </p>
  </div>
</script>
</div>
</body>
</html>