<?php
include("config.php");
include("firebaseRDB.php");

// Use null coalescing operator to handle undefined keys
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($name)){
    echo "Name is required";
}else if(empty($email)){
    echo "Email is required";
}else if(empty($password)){
    echo "Password is required";
}else{
    $rdb = new firebaseRDB($databaseURL);
    $retrieve = $rdb->retrieve("/user", "email", "EQUAL", $email);
    $data = json_decode($retrieve, true);

    // Check if data array is not empty and contains the 'email' key
    if(!empty($data) && isset($data['email'])){
        echo "Email already used";
    }else{
        $insert = $rdb->insert("/user", [
            "name" => $name,
            "email" => $email,
            "password" => $password
        ]);

        $result = json_decode($insert, 1);
        if(isset($result['name'])){
            echo "Signup success, please login";
        }else{
            echo "Signup failed";
        }
    }
}
?>
