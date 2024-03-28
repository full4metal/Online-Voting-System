<?php
	include 'includes/conn.php';

	if(isset($_POST['submit'])){
		$userid = $_POST['username'];
        $firstname = $_POST['fullname'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $dob = $_POST['dob'];
        //check
        $check_sql = "SELECT * FROM voter WHERE userid = '$userid'";
        $check_result = $conn->query($check_sql);
            if($check_result->num_rows > 0)
            {
                $msg="This id is associated with another account";

            } else {
                $sql = "INSERT INTO voter (userid ,fullname , password, dob) VALUES ('$userid', '$firstname', '$password','$dob')";
                if($conn->query($sql)){
                    $_SESSION['success'] = 'Voter added successfully';
                }else{
                    $_SESSION['error'] = 'Fill up add form first';
                }
            }  
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Registration Form</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Voter Registration Form</h1>

  <?php if(isset($msg)): ?>
            <div class="error"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form id="voter-registration-form" action="" method="POST">
       
            <div class="form-group">
                <label for="user-id">User ID</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="full-name">Full Name</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
        
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>

            <button type="submit" name="submit" >Register</button>
            <a href="index.php"><button type="button" id="login">Login</button></a>
        </form>
    
    </div>
    
</body>
</html>
