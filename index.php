<?php
    session_start();

    // include connection file
    include("connect.php");
    require_once("User.php");

    // define variables and initialize with empty values
    $username = $password = "";
    $err = $username_err = $password_err = "";
    
    // processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "*Please enter username";
        }else {
            $username = trim($_POST["username"]);
        }

        // check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "*Please enter password";
        } else{
            $password = md5(trim($_POST["password"]));
        }

        // validate credentials
        if(empty($username_err) && empty($password_err)){
            $sql = "SELECT * FROM tbluser WHERE username = '$username' AND password = '$password'" ;
            $result = $conn->query($sql) ;
	        $count = $result->num_rows;
            if($count > 0){
		        $row = $result -> fetch_array(MYSQLI_NUM);
		        //printf ("%s (%s)\n", $row[0], $row[1]);
                //$err = "*Sucess";
                $_SESSION["id"] = $row[0];
                $_SESSION["username"] = $row[1];
                if($row[3] == 1 ){
                    header("location: ./teacher/index.php");
                    exit();
                }else{
                    header("location: ./student/index.php");
                    exit();
                }
            } else {
                $err = "*Username or password is invalid";
	        }
	
        }

        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sanglv11</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
        
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form" method="post">
        <h1>LOGIN</h1>
        <?php echo "<span class='err'>".$err."</span>" ?>
        <?php echo "<span class='err'>".$username_err."</span>" ?>
        <input type="text" name="username" placeholder="Username">
        <?php echo "<span class='err'>".$password_err."</span>" ?>
        <input type="password" name="password" placeholder="Password">
        <!-- <input type="text" name="password" placeholder="Password"> -->
        <input type="submit" value="Log in">
    </form>
    
</body>
</html>
