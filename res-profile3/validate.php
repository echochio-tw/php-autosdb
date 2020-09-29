<?
function flashMessage(){
    if(isset($_SESSION['error'])){
        echo('<p style="color: red;">"'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    if(isset($_SESSION['success'])){
            echo('<p style="color: green;">"'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['sussess']);
    }
}
function loadPos($pdo, $profile_id){
    error_log("loadPos ".$profile_id);
    $stmt = $pdo->prepare('SELECT * FROM Position WHERE profile_id =:prof ORDER BY rank');
    $stmt->execute(array(':prof' => $profile_id));
    $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $positions;
}
function loadEdu($pdo, $profile_id){
    error_log("loadEdu ".$profile_id);
    $stmt = $pdo->prepare("SELECT year,name FROM Education JOIN Institution ON Education.institution_id = Institution.institution_id WHERE profile_id = :prof ORDER BY rank");
    $stmt->execute(array(':prof' => $profile_id));
    $educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $educations;
}
function validatePos() {
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;
        error_log("POS post print ".$_POST['year'.$i]);
        error_log("POS post print ".$_POST['desc'.$i]);
        $_SESSION['year'.$i] = $_POST['year'.$i];
        $_SESSION['desc'.$i] = $_POST['desc'.$i];
        error_log("post Add".$_SESSION['year'.$i].' '.$_SESSION['desc'.$i]);
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
function validateEdu() {
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['eduyear'.$i]) ) continue;
        if ( ! isset($_POST['eduschool'.$i]) ) continue;
        error_log("Edu post print ".$_POST['eduyear'.$i]);
        error_log("Edu post print ".$_POST['eduschool'.$i]);
        $_SESSION['eduyear'.$i] = $_POST['eduyear'.$i];
        $_SESSION['eduschool'.$i] = $_POST['eduschool'.$i];
        error_log("post Add".$_SESSION['eduyear'.$i].' '.$_SESSION['eduschool'.$i]);
        error_log("post to session ".eduschool.$i);
        if ( strlen($_SESSION['eduyear'.$i]) == 0 || strlen($_SESSION['eduschool'.$i]) == 0 ) {
            unset($_SESSION['eduyear'.$i]);
            unset($_SESSION['eduschool'.$i]);
            return '<p style="color: red;">All fields are required</p>';            
        }

        if ( ! is_numeric($_SESSION['eduyear'.$i]) ) {
            unset($_SESSION['eduyear'.$i]);
            unset($_SESSION['eduschool'.$i]);
            return '<p style="color: red;">Position year must be numeric</p>';
        }
    }
    return true;
}
function inserPositions($pdo, $profile_id){
    $rank = 1;
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_SESSION['year'.$i]) ) continue;
        if ( ! isset($_SESSION['desc'.$i]) ) continue;
        $year = $_SESSION['year'.$i];
        $desc = $_SESSION['desc'.$i];
        $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES (:pid, :rank, :year, :desc)');
        $stmt->execute(array(':pid' => $profile_id, ':rank' => $rank, ':year' => $year, ':desc' => $desc));
        $rank++;
        unset($_SESSION['year'.$i]);
        unset($_SESSION['desc'.$i]);
      }
}
function insertEducations($pdo, $profile_id){
    $rank = 1;
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_SESSION['eduyear'.$i]) ) continue;
        if ( ! isset($_SESSION['eduschool'.$i]) ) continue;
        $year = $_SESSION['eduyear'.$i];
        $school = $_SESSION['eduschool'.$i];
        $institution_id = false;
        $stmt = $pdo->prepare('SELECT institution_id FROM Institution WHERE name =:name');
        $stmt->execute(array(':name' => $school));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row !== false ) $institution_id = $row['institution_id'];
        if ($institution_id === false){
            $stmt = $pdo->prepare('INSERT INTO Institution(name) VALUES(:name)');
            $stmt->execute(array(':name' => $school));
            $institution_id = $pdo->lastInsertId();
        }
        $stmt = $pdo->prepare('INSERT INTO Education (profile_id, rank, year, institution_id) VALUES (:pid, :rank, :year, :iid)');
        $stmt->execute(array(':pid' => $profile_id, ':rank' => $rank, ':year' => $year, ':iid' => $institution_id));
        $rank++;
        unset($_SESSION['eduyear'.$i]);
        unset($_SESSION['eduschool'.$i]);
    }
}
?>
