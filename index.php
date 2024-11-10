<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLCK LOCALS ™</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f7;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin: 0;
        }
        h1, h3 {
            color: #444;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            
        }
        h3 {
            font-size: 1.2em;
            margin-top: 10px;
            
        }
        a {
            color: #57b9ff;
            text-decoration: none;
            font-weight: bold;
            
        }
        a:hover {
            color: #77b1d4;
        }
        .message {
            color: #66eb36;
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            border-radius: 8px;
            padding: 25px;
            width: 100%;
            max-width: 450px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        form p {
            margin: 15px 0;
        }
        label {
            display: block;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }
        input[type="text"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #57b9ff;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #77b1d4;
        }
        .container {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .container h3 {
            margin: 8px 0;
            color: #34495e;
        }
        .editAndDelete {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }
        .editAndDelete a {
            background-color: #57b9ff;
            color: white;
            border-radius: 5px;
            padding: 8px 12px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .editAndDelete a:hover {
            background-color: #77b1d4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
  
        .action-logs-container {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    
    <?php if (isset($_SESSION['message'])) { ?>
        <h1 class="message"><?php echo $_SESSION['message']; ?></h1>
    <?php } unset($_SESSION['message']); ?>

    <?php if (isset($_SESSION['username'])) { ?>
        <h1>ACCOUNT LOGGED IN: <?php echo $_SESSION['username']; ?>!</h1>
        <a href="core/handleForms.php?logoutAUser=1">Logout</a>
    <?php } else { echo "<h1>No user logged in</h1>"; } ?>

    <h3>Users List</h3>
    <ul>
        <?php $getAllUsers = getAllUsers($pdo); ?>
        <?php foreach ($getAllUsers as $row) { ?>
            <li>
                <a href="viewuser.php?user_id=<?php echo $row['user_id']; ?>"><?php echo $row['username']; ?></a>
            </li>
        <?php } ?>
    </ul>

    <h1>Add New Customer</h1>
    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="username">Username</label> 
            <input type="text" name="username">
        </p>
        <p>
            <label for="firstName">First Name</label> 
            <input type="text" name="firstName">
        </p>
        <p>
            <label for="lastName">Last Name</label> 
            <input type="text" name="lastName">
        </p>
        <p>
            <label for="dateOfBirth">Date of Birth</label> 
            <input type="date" name="dateOfBirth">
        </p>
        <p>
            <label for="country">Country</label> 
            <input type="text" name="country">
            <input type="submit" name="insertCoachBtn" value="Add Customer">
        </p>
    </form>

    <?php $getAllCoach = getAllCoach($pdo); ?>
    <?php foreach ($getAllCoach as $row) { ?>
    <div class="container">
        <h3>Username: <?php echo $row['username']; ?></h3>
        <h3>First Name: <?php echo $row['first_name']; ?></h3>
        <h3>Last Name: <?php echo $row['last_name']; ?></h3>
        <h3>Date of Birth: <?php echo $row['date_of_birth']; ?></h3>
        <h3>Country: <?php echo $row['country']; ?></h3>
        <h3>Date Added: <?php echo $row['date_added']; ?></h3>
        <h3>Added by: <?php echo $row['added_by']; ?></h3>
        <h3>Last Updated: <?php echo $row['last_updated']; ?></h3>
        <h3>Edited by: <?php echo $row['edited_by']; ?></h3>

        <div class="editAndDelete">
            <a href="vieworders.php?customer_id=<?php echo $row['customer_id']; ?>">View Orders</a>
            <a href="editcustomer.php?customer_id=<?php echo $row['customer_id']; ?>">Edit</a>
            <a href="deletecustomer.php?customer_id=<?php echo $row['customer_id']; ?>">Delete</a>
        </div>
    </div> 
    <?php } ?>



</body>
</html>
