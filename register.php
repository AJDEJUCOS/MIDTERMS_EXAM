<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f9f9f9;
			color: #333;
			display: flex;
			flex-direction: column;
			align-items: center;
			padding: 20px;
		}
		h1 {
			color: #444;
			font-size: 2em;
			margin-bottom: 10px;
		}
		.form-container {
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 8px;
			padding: 20px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			width: 300px;
			text-align: center;
		}
		p {
			margin: 15px 0;
		}
		label {
			display: block;
			font-weight: bold;
			margin-bottom: 5px;
			font-size: 1.2em;
			color: #555;
		}
		input[type="text"],
		input[type="password"] {
			font-size: 1em;
			width: 100%;
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #ccc;
			box-sizing: border-box;
		}
		input[type="submit"] {
			font-size: 1.2em;
			padding: 10px;
			width: 100%;
			background-color: #57b9ff;
			color: white;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			margin-top: 15px;
		}
		input[type="submit"]:hover {
			background-color: #77b1d4;
		}
		.message {
			color: #66eb36;
			font-size: 1.2em;
			margin-bottom: 20px;
		}
	</style>
</head>
<body>
	<h1>Create Account</h1>
	<?php if (isset($_SESSION['message'])) { ?>
		<h1 class="message"><?php echo $_SESSION['message']; ?></h1>
	<?php } unset($_SESSION['message']); ?>
	<div class="form-container">
		<form action="core/handleForms.php" method="POST">
			<p>
				<label for="username">Username</label>
				<input type="text" name="username">
			</p>
			<p>
				<label for="password">Password</label>
				<input type="password" name="password">
				<input type="submit" name="registerUserBtn" value="Register">
			</p>
		</form>
	</div>
</body>
</html>
