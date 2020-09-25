<?php
    session_start();
    include("../User.php");
    include("../connect.php");
    $challenge_list = $title = $hint = "";
    $id = $_SESSION["id"];
    // click submit assignment 
    if(isset($_POST["submit"])){
        $title = $_POST["title"];
        $hint = $_POST["hint"];

        if(!empty($title) && !empty($hint)){
            // check whether chose file yet
            if(!empty($_FILES["file"]["name"])){
                $targetDir = "../challenge/";
                $fileNameTmp = basename($_FILES["file"]["name"]);
                $fileName = $title.".".$fileNameTmp;
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                
                $allowTypes = array('txt');
                // check format
                if(in_array($fileType, $allowTypes)){

                    if($_FILES["file"]["size"] > 2097152){
                        $err = "*Your file is too large";
                    }else{
                        // upload file to server
                        if(file_exists("$targetFilePath")) unlink("$targetFilePath");
                        $id = $_SESSION["id"];
                        $sql = "INSERT INTO tblchallenge (id_teacher, title, hint, updateon) VALUES('$id','$title','$hint', NOW())";
                        if($conn->query($sql)==true){
                            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                                $err = "Upload sucessfully";                            
                            }else{
                                $err = "There was an error uploading your file";
                            }                            
                        }else{
                            $err = "Something went wrong. Try again";
                        } 
                    }  
                }else{
                    $err = "Only TXT files are allowed to upload.";
                }
            }else{
                $err = "Please select a file to upload";
            }
        }else{
            $err = "*Title or Hint can not be empty";
        }
        
    }

    // show assignment list
    $sql = "SELECT * FROM tblchallenge WHERE id_teacher='$id'";
    $result = $conn->query($sql);
    while($row = $result->fetch_array(MYSQLI_NUM)) { 
        // process each row
        $challenge_list .= "<tr>";
        $challenge_list .= "<th>".$row[2]."</th>";
        $challenge_list .= "<th>".$row[4]."</th>";
        // $challenge_list .= "<th> <a href=''> Xem danh sach</a> </th>";
        $challenge_list .= "</tr>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="teacher.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- side bar  -->
    <div class="sidebar" >
        <ul class="menu">
            <li>
               <a href="index.php"> <i class="fas fa-user"></i> <?php echo "<span>".$_SESSION["username"]."</span>"; ?> </a> 
            </li>
            <li>
                <a href="student_show.php">Students</a>
            </li>
            <li>
                <a href="user.php">Users</a>
            </li>
            <li>
                <a href="assignment.php" >Assignment</a>
            </li>
            <li>
                <a href="#" class="darkblue">Challenge</a>
            </li>
            <li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>

    </div>

    <!-- assignment tab -->
    <div class="content" id="assignment">
        
        <form action="" method="post" enctype="multipart/form-data" class="assignment">
            <label for="title">Challenge's Name:</label> 
            <input type="text" id="title" name="title" value="<?php echo $title;?>"><br><br>
            <label for="hint">Hint:</label><br><br>
            <textarea id="hint" name="hint" rows="5" cols="50"><?php echo $hint;?></textarea><br><br>
            <label for="myfile">Select file:</label> 
            <input type="file" id="myfile" name="file"><br><br>
			<input type="submit" value="Upload" name="submit"><br><br>
            <span class="err"> <?php echo $err ?> </span>
		</form>

        <div class="assignment-list">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Update on</th>
                </tr>
                <?php 
                    echo $challenge_list;
                ?>
            </table>
        </div>
    </div>

</body>
</html>