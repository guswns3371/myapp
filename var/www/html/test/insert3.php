<?php

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $response = array();
    $name=$_POST['name'];
    $country=$_POST['country'];

    require_once('config.php');

    $sql = "SELECT * FROM person WHERE name = '$name'";
    $check = mysqli_fetch_array(mysqli_query($con,$sql));
    if(isset($check)){
        $response["value"] = 0;
        $response["message"] = "omg";
        echo json_encode($response);
    }else{
        $sql = "INSERT INTO person (name,country) VALUES ('$name','$country')";
        if(mysqli_query($con,$sql)){
            $response["value"] = 1;
            $response["message"] = "success";
            echo json_encode($response);
        }else{
            $response["value"] = 0;
            $response["message"] = "omg";
            echo json_encode($response);
        }
    }

    mysqli_close($con);
}else{
    $response["value"] = 0;
    $response["message"] = "omg";
    echo json_encode($response);
}
?>