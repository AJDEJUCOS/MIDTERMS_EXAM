<?php 

require_once 'dbConfig.php'; 
require_once 'models.php';

if (isset($_POST['insertCoachBtn'])) {

	$query = insertCoach($pdo, $_POST['username'], $_POST['firstName'], 
		$_POST['lastName'], $_POST['dateOfBirth'], $_POST['country'], $_SESSION['user']);

	if ($query) {
		header("Location: ../index.php");
	}
	else {
		echo "Insertion failed";
	}

}


if (isset($_POST['editCoachBtn'])) {
	$t=time();
	$query = updateCoach($pdo, $_POST['firstName'], $_POST['lastName'], 
		$_POST['dateOfBirth'], $_POST['country'], $_SESSION['user'], $_GET['customer_id'] );

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Edit failed";;
	}

}




if (isset($_POST['deleteCoachBtn'])) {
    $query = deleteCoach($pdo, $_GET['customer_id'], $_SESSION['user']);

    if ($query) {
        header("Location: ../index.php");
    } else {
        echo "Deletion failed";
    }
}

if (isset($_POST['insertNewClientBtn'])) {
	$query = insertClient($pdo, $_POST['firstName'], $_POST['lastName'], $_GET['customer_id'], $_SESSION['user']);

	if ($query) {
		header("Location: ../vieworders.php?customer_id=" .$_GET['customer_id']);
	}
	else {
		echo "Insertion failed";
	}
}


if (isset($_POST['editClientBtn'])) {
	$query = updateClient($pdo, $_POST['firstName'], $_POST['lastName'], $_SESSION['user'], $_GET['order_id']);

	if ($query) {
		header("Location: ../vieworders.php?customer_id=" .$_GET['customer_id']);
	}
	else {
		echo "Update failed";
	}

}


if (isset($_POST['deleteClientBtn'])) {
    $query = deleteClient($pdo, $_GET['order_id'], $_SESSION['user']);

    if ($query) {
        header("Location: ../vieworders.php?customer_id=" . $_GET['customer_id']);
    } else {
        echo "Deletion failed";
    }
}

if (isset($_POST['registerUserBtn'])) {

	$username = $_POST['username'];
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$insertQuery = insertNewUser($pdo, $username, $password);

		if ($insertQuery) {
			header("Location: ../login.php");
		}
		else {
			header("Location: ../register.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty for registration!";

		header("Location: ../login.php");
	}

}




if (isset($_POST['loginUserBtn'])) {

	$username = $_POST['usernames'];
	$password = sha1($_POST['passwords']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = loginUser($pdo, $username, $password);
	
		if ($loginQuery) {
			header("Location: ../index.php");
			$_SESSION['user'] = $username;
		}
		else {
			header("Location: ../login.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty for the login!";
		header("Location: ../login.php");
	}
 
}



if (isset($_GET['logoutAUser'])) {
	unset($_SESSION['username']);
	header('Location: ../login.php');
}


?>