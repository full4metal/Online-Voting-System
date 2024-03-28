<?php
	include 'includes/session.php';

	// approve_voter.php
	if(isset($_POST['edit'])){
		$voterId = $_POST['id'];
		
		$sql = "UPDATE voter SET status = 1 WHERE id = '$voterId'";
		$query = $conn->query($sql);
		if($conn->query($sql)){
			$_SESSION['success'] = 'Voter Approved successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	// Redirect to the admin panel or another appropriate page
		header('Location: voters.php');


?>
