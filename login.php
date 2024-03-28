<?php
	session_start();
	include 'includes/conn.php';

	if(isset($_POST['login'])){
		$voter = $_POST['voter'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM voter WHERE userid = '$voter'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find voter with the ID';
		}
		else{
			$row = $query->fetch_assoc();

				if ($row['status'] == 1) {


						if(password_verify($password, $row['password'])){
							$_SESSION['voter'] = $row['id'];
						}
						else{
							$_SESSION['error'] = 'Incorrect password';
						}			
		} else {
			// Display a message indicating that the voter is not approved
			$_SESSION['error'] = 'Voter not approved';
		}
		}		
	}
	else{
		$_SESSION['error'] = 'Input voter credentials first';
	}
	header('location: index.php');
?>