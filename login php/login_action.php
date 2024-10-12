<?php
include("config.php");
include("firebaseRDB.php");

/*echo '<pre>';
//print_r($_POST); // To print the POST array to check if hinkwat ti data sent ti correctly
echo '</pre>';*/

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($email)){
    echo "Email is required";
}else if(empty($password)){
    echo "Password is required";
}else{
    $rdb = new firebaseRDB($databaseURL);
    $retrieve = $rdb->retrieve("/user", "email", "EQUAL", $email);
    //echo $retrieve;
    $data = json_decode($retrieve, true);

    if(count($data) == 0){
        echo "Email not registerd";
    }else{
        $id = array_keys($data)[0];
        if($data[$id]['password'] == $password){
            $_SESSION['user'] = $data[$id];
            header("location: dashboard.php");
        }else{
            echo "Login failed";
        }
    }
}
?>
