<?php

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $response = array();
    require_once ('../config.php');

    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_pw'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];

    error_log("set_userinfo_1 : ".$user_id." / ".$user_pw." / ".$user_name." / ".$user_email);

    $target_dir = "/var/www/html/MusicPlayer/uploads/userimg/";
    $_FILES["file"]["name"] = $user_email."_".$_FILES["file"]["name"];
    $target_dir = $target_dir .basename($_FILES["file"]["name"]);
    $Photo = $_FILES["file"]["name"];
    $Photo = "/MusicPlayer/uploads/userimg/".$Photo;

    $sql = "select * from  UserInfo where user_email  = '$user_email'";
    $check = mysqli_fetch_array(mysqli_query($con,$sql));

    if (isset($check)){
        $value =0;
        $message = "Already Existing UserEmail";
    }else{
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir)){
            $user_img = $Photo; // img_photo

            $sql = "insert into UserInfo 
                      (user_id,user_pw,user_name,user_email,user_img)
                      values 
                      ('$user_id','$user_pw','$user_name','$user_email','$user_img')";

            if(mysqli_query($con,$sql)){
                $sql = mq("select * from  UserInfo where user_email  = '$user_email'");
                if ($row = mysqli_fetch_array($sql)){
                    $idx = $row['user_idx'];
                    $pw = $row['user_pw'];
                    $img_path = $row['user_img'];
                    $email = $row['user_email'];
                    error_log("set_userinfo_2 : ".$idx." / ".$pw." / ".$img_path." / ".$email);
                }
                $value =1;
                $message = "Success";
            }else{
                $value =0;
                $message = "Insert Fail";
            }
        }else{
            $value =0;
            $message = "File Upload Fail";
        }

        mysqli_close($con);
    }
}else{
    $value =0;
    $message = "Server Connection Fail";
}

$response['value'] = $value;
$response['message'] = $message;
echo json_encode($response);
?>