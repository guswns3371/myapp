<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) )
{

    $Userid=$_POST['Userid'];
    $Password=$_POST['Password'];
    $Username=$_POST['Username'];
    $Email=$_POST['Email'];
    $Birthday=$_POST['Birthday'];

    if(empty($Userid)){
        $errMSG = "ID를 입력하세요.";
    }
    else if(empty($Password)){
        $errMSG = "비밀번호를를 입력하세요.";
    }

    if(!isset($errMSG))
    {
        try{
            $stmt = $con->prepare('INSERT INTO UserInfo(Userid, Password, Username, Email, Birthday) VALUES(:Userid, :Password, :Username, :Email, :Birthday)');
            $stmt->bindParam(':Userid', $Userid);
            $stmt->bindParam(':Password', $Password);
            $stmt->bindParam(':Username', $Username);
            $stmt->bindParam(':Email', $Email);
            $stmt->bindParam(':Birthday', $Birthday);

            if($stmt->execute())
            {
                $successMSG = "새로운 사용자를 추가했습니다.";
            }
            else
            {
                $errMSG = "사용자 추가 에러";
            }

        } catch(PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

}
?>
<?php
if (isset($errMSG)) echo $errMSG;
if (isset($successMSG)) echo $successMSG;

if (!$android)
{
    ?>
    <html>
    <body>
    <form action="<?php $_PHP_SELF ?>" method="POST">
        Userid: <input type = "text" name = "Userid" />
        Password: <input type = "text" name = "Password" />
        Username: <input type = "text" name = "Username" />
        Email: <input type = "text" name = "Email" />
        Birthday: <input type = "text" name = "Birthday" />
        <input type = "submit" name = "submit" />
    </form>

    </body>
    </html>

    <?php
}
?>