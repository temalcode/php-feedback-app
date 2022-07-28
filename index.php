<?php

	$host = 'localhost';
	$username = 'root';
	$password = '';
	$db = 'php1';

	$conn = new mysqli($host, $username, $password, $db);
	if (!$conn) {
  		die("Connection failed: " . mysqli_connect_error());
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if($_POST['feedback'] == "" || $_POST['name'] == ""){
			echo '
				<div class="container mt-4">
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Please fill all the fields
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div> </div>';
		} else{
			$user_input = htmlspecialchars($_POST['feedback']);
			$user_name = htmlspecialchars($_POST['name']);
			$sql = "INSERT INTO feedback(name, message) VALUES (\"$user_name\", \"$user_input\")";
			if($conn->query($sql) == true){
				echo '
				<div class="container mt-4">
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				Feedback added successfully to the database 
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div> </div>';
			} else{
				echo $conn->error;
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href=".\bootstrap-5.1.3-dist\css\bootstrap.min.css">
	<script defer src=".\bootstrap-5.1.3-dist\js\bootstrap.min.js"></script>
	<title>Feedback</title>
</head>
<body>
	<div class="container my-5">
		<h2 class="mb-4">PHP Feedback App</h2>
	<form action="index.php" method="post">
		<div class="row">
			<div class="col">
				<input type="text" class="form-control" name="name" placeholder="Enter your name">
			</div>
			<div class="col">	
				<input type="text" class="form-control" name="feedback" placeholder="Feedback"> 
			</div>
			<div class="col">
				<input type="submit" class="btn btn-primary" value="submit">
		</div>
		</div>
	</form>

	<div class="w-50 mt-5">
	<ol class="list-group list-group-numbered">
	<?php
		$sql = "SELECT * FROM feedback";
		$result = $conn->query($sql);
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$name = $row['name'];
				$message = $row['message'];
				echo "<li class=\"list-group-item\">$message (by $name)</li>";
			}
		} else{
			echo 'no feedbacks';
		}
	?>
	</ol>
	</div>


	</div>

</body>
</html>