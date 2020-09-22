<?
function validatePos() {
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;
        $_SESSION['year'.$i] = $_POST['year'.$i];
        $_SESSION['desc'.$i] = $_POST['desc'.$i];
        if ( strlen($_SESSION['year'.$i]) == 0 || strlen($_SESSION['desc'.$i]) == 0 ) {
            unset($_SESSION['year'.$i]);
            unset($_SESSION['desc'.$i]);
            return '<p style="color: red;">All fields are required</p>';
        }

        if ( ! is_numeric($_SESSION['year'.$i]) ) {
            unset($_SESSION['year'.$i]);
            unset($_SESSION['desc'.$i]);
            return '<p style="color: red;">Position year must be numeric</p>';
        }
    }
    return true;
}
?>
