<?php
	$servername = "localhost";
	$username = "root";
	$password = "SAng19$$$";
	$database = "vcs";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	// else echo "Connected successfully";

	// echo "cac";

	// $username = "sanglv12";
	// $password = "56563000";

	// $sql = "SELECT * FROM tbluser WHERE username = '$username' AND password = '$password'" ;
    // $result = $conn->query($sql) ;
	// $count = $result->num_rows;
    // if($count > 0){
	// 	$row = $result -> fetch_array(MYSQLI_NUM);
	// 	printf ("%s (%s)\n", $row[0], $row[1]);
      
    // } else {
    //     echo "err";
	// }
	
	// echo "cac";
?>