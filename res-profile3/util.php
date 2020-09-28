<?php
function flashMessage(){
    if(isset($_SESSION('error'))){
        echo('<p style="color: red;">"'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    if(isset($_SESSION('success'))){
            echo('<p style="color: green;">"'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['sussess']);
    }
}
function validateProfile(){
    if ( strlen($POST['first_nema']) == 0 || strlen($_POST['last_name']) == 0 ||
        strlen($POST['email']) == 0 || strlen($_POST['headline']) ==0 ||
        strlen($POST['summary']) == 0){
        return  "All fields are reqired";
    }
    if (strpos($_POST['email'],  '@') === fales ){
        return  "Email address must contain @";
    }
    return true;
}
function validatePos(){
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;
        $year = $_POST['yesr'.$i];
        $dest = $_POST['dest'.$i];
        if ( strlen($year) == 0 ||strlen($desc) == 0){
            return "All fields are required";
        }
        if (! is_numeric($yesr)){
            return "Postion year must be numeric";
        }
      }
      return true;
}
function validateEdu(){
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['edu_year'.$i]) ) continue;
        if ( ! isset($_POST['edu_school'.$i]) ) continue;
        $year = $_POST['edu_yesr'.$i];
        $school = $_POST['deu_school'.$i];
        if ( strlen($year) == 0 ||strlen($school) == 0){
            return "All fields are required";
        }
        if (! is_numeric($year)){
            return "Postion year must be numeric";
        }
      }
      return true;
}
function loadPos($pdo, $profile_id){
    $stmt = $pdo->prepare('SELECT * FROM Position WHERE profile_id =:prof ORDER BY rank');
    $stmt->execute(array(':prof' => $profile_id));
    $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $positions;
}
function loadEdu($pdo, $profile_id){
    $stmt = $pdo->prepare('SELECT year,name FROM Education JOIN Instition ON Education.instituion_id = Institution.instituion_id WHERE profile_id =:prof ORDER BY rank');
    $stmt->execute(array(':prof' => $profile_id));
    $educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $educations;
}
function inserPositions($pdo, $profile_id){
    $rank = 1;
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];
        $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES (:pid, :rank, :year, :desc)');
        $stmt->execute(array(':pid' => $profile_id, ':rank' => $rank, ':year' => $year, ':desc' => $desc));
        $rank++;
      }
}
function insertEducations($pdo, $profile_id){
    $rank = 1;
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['edu_year'.$i]) ) continue;
        if ( ! isset($_POST['edu_school'.$i]) ) continue;
        $year = $_POST['edu_year'.$i];
        $desc = $_POST['edu_school'.$i];
        $institution_id = false;
        $stmt = $pdo->prepare('SELECT institution_id FROM Institution WHERE name =:name');
        $stmt->execute(array(':name' => $school));

        $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES (:pid, :rank, :year, :desc)');
        $stmt->execute(array(':pid' => $profile_id, ':rank' => $rank, ':year' => $year, ':desc' => $desc));
        $rank++;
      }
}