<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$db="c1_ovi";
	/*$servername = "localhost";
	$username = "c1ovi";
	$password = "ZJvF4fABb#zq";
	$db="c1_ovi";*/
		// Create connection
	$conn = mysqli_connect($servername, $username, $password);
  // Check connection
	if (!$conn) {
  	die("Connection failed: " . mysqli_connect_error());
	}
	// Create database
	if(!mysqli_select_db($conn,$db))
	{
	$sql = "CREATE DATABASE ".$db;
	if (mysqli_query($conn, $sql)) {
	  //echo "Database created successfully";
		mysqli_select_db($conn,$db);
		//CREARE USERS
		$sql = "CREATE TABLE IF NOT EXISTS users (
								user_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
								name VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
								password VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
								email VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL
		)";
		// CREARE TASKS
		if (mysqli_query($conn, $sql)){
		//echo "Table user created successfully";
	}
		else {
						 echo "Error creating user: " . mysqli_error($conn);
				 }
		$sql = "CREATE TABLE IF NOT EXISTS tasks (
								task_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
								user_id INT(11) NOT NULL,
								task_string VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
								category_id INT(11) NOT NULL DEFAULT '0',
								task_status TINYINT(1) NOT NULL DEFAULT '0'
		)";
		//CREARE TASKS
		if(mysqli_query($conn,$sql)){
						//echo "Table tasks created successfully";
															 }
		else {
								echo "Error creating tasks: " . mysqli_error($conn);
		     }
		$sql = "CREATE TABLE IF NOT EXISTS categories (
								category_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
								category_name VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
								user_id VARCHAR(100) NOT NULL
		)";

		//CREARE CATEGORIES
		if(mysqli_query($conn,$sql)){}
							//echo "Table categories created successfully";
	  else {
							echo "Error creating categories: " . mysqli_error($conn);
			   }
	} // END OF DATABASE CREATE IF
	else {
	  				echo "Error creating database: " . mysqli_error($conn);
	}
} // END OF IF IT DOESNT EXIST
else {
	$sql = "CREATE TABLE IF NOT EXISTS users (
							user_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
							name VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
							password VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
							email VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL
	)";
// CREARE USERS
	if (mysqli_query($conn, $sql)){
	//echo "Table user created successfully";
}
	else {
					 echo "Error creating user: " . mysqli_error($conn);
			 }
	$sql = "CREATE TABLE IF NOT EXISTS tasks (
							task_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
							user_id INT(11) NOT NULL,
							task_string VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
							category_id INT(11) NOT NULL DEFAULT '0',
							task_status TINYINT(1) NOT NULL DEFAULT '0'
	)";
//CREARE TASKS
 if(mysqli_query($conn,$sql)){
					//echo "Table tasks created successfully";
														 }
 else {
							echo "Error creating tasks: " . mysqli_error($conn);
      }
	$sql = "CREATE TABLE IF NOT EXISTS categories (
							category_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
							category_name VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
							user_id VARCHAR(100) NOT NULL
	)";
//CREARE CATEGORIES
if(mysqli_query($conn,$sql)){}
					//echo "Table categories created successfully";
else {
					echo "Error creating categories: " . mysqli_error($conn);
		 }

}
?>
