<?php  

function insertCoach($pdo, $username, $first_name, $last_name, $date_of_birth, $country) {
    $sql = "INSERT INTO customers (username, first_name, last_name, date_of_birth, country) VALUES(?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$username, $first_name, $last_name, $date_of_birth, $country]);

    if ($executeQuery) {
        return true;
    }
}


function updateCoach($pdo, $first_name, $last_name, 
	$date_of_birth, $country, $edited_by, $customer_id) {

	$sql = "UPDATE customers
				SET first_name = ?,
					last_name = ?,
					date_of_birth = ?, 
					country = ?,
					last_updated = now(),
					edited_by = ?
				WHERE customer_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, 
		$date_of_birth, $country, $edited_by, $customer_id]);
	
	if ($executeQuery) {
		return true;
	}

}


function deleteCoach($pdo, $customer_id, $deleted_by) {
    $deleteClientQuery = "DELETE FROM orders WHERE client_owner = ?";
    $deleteStmt = $pdo->prepare($deleteClientQuery);
    $executeDeleteQuery = $deleteStmt->execute([$customer_id]);

    if ($executeDeleteQuery) {
        $sql = "DELETE FROM customers WHERE customer_id = ?";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$customer_id]);

        if ($executeQuery) {
            // Log the deletion
            logAction($pdo, 'delete', $customer_id, 'coach', $deleted_by);
            return true;
        }
    }
    return false;
}



function getAllCoach($pdo) {
	$sql = "SELECT * FROM customers";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getCoachByID($pdo, $customer_id) {
	$sql = "SELECT * FROM customers WHERE customer_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$customer_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function getordersByCoach($pdo, $customer_id) {
    $sql = "SELECT 
                orders.order_id AS order_id,
                orders.first_name AS first_name,
                orders.last_name AS last_name,
                orders.date_added AS date_added,
                orders.added_by AS added_by,
                orders.last_updated AS last_updated,
                orders.edited_by AS edited_by,
                CONCAT(customers.first_name, ' ', customers.last_name) AS coach_name
            FROM orders
            JOIN customers ON orders.client_owner = customers.customer_id
            WHERE orders.client_owner = ? 
            GROUP BY orders.first_name";
    
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$customer_id]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}


function getAllInfoByCoachID($pdo, $customer_id) {
	$sql = "SELECT * FROM customers WHERE customer_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$customer_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function insertClient($pdo, $first_name, $last_name, $client_owner, $added_by) {
    $sql = "INSERT INTO orders (first_name, last_name, client_owner, added_by, last_updated) VALUES (?, ?, ?, ?, NULL)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $client_owner, $added_by]);
    if ($executeQuery) {
        return true;
    }
}

function getClientByID($pdo, $order_id) {
    $sql = "SELECT 
                orders.order_id AS order_id,
                orders.first_name AS first_name,
                orders.last_name AS last_name,
                orders.date_added AS date_added,
                orders.added_by AS added_by,
                orders.last_updated AS last_updated,
                orders.edited_by AS edited_by,
                CONCAT(customers.first_name, ' ', customers.last_name) AS client_owner
            FROM orders
            JOIN customers ON orders.client_owner = customers.customer_id
            WHERE orders.order_id = ? 
            GROUP BY orders.first_name";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$order_id]);
    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function updateClient($pdo, $first_name, $last_name, $edited_by, $order_id) {
	$sql = "UPDATE orders
			SET first_name = ?,
				last_name = ?,
                last_updated = now(),
                edited_by = ?
			WHERE order_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $edited_by, $order_id]);

	if ($executeQuery) {
		return true;
	}
}


function deleteClient($pdo, $order_id, $deleted_by) {
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$order_id]);

    if ($executeQuery) {
    
        logAction($pdo, 'delete', $order_id, 'client', $deleted_by);
        return true;
    }
    return false;
}

function logAction($pdo, $action_type, $affected_id, $affected_type, $user) {
    $sql = "INSERT INTO action_logs (action_type, affected_id, affected_type, user) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$action_type, $affected_id, $affected_type, $user]);
}

function getAllActionLogs($pdo) {
    $sql = "SELECT * FROM action_logs ORDER BY timestamp DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll();
}


function insertNewUser($pdo, $username, $password) {

	$checkUserSql = "SELECT * FROM user_passwords WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO user_passwords (username,password) VALUES(?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "REGISTRATION SUCCESSFUL";
			return true;
		}

		else {
			$_SESSION['message'] = "AN ERROR OCCURED FROM THE QUERY";
		}

	}
	else {
		$_SESSION['message'] = "ACCOUNT ALREADY EXIST";
	}

	
}



function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM user_passwords WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['username'] = $usernameFromDB;
			$_SESSION['message'] = "LOGIN SUCCESSFUL";
			return true;
		}

		else {
			$_SESSION['message'] = "INCORRECT PASSWORD";
		}
	}

	
	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "ACCOUNT DOES NOT EXIST";
	}

}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_passwords";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}

}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM user_passwords WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}


?>