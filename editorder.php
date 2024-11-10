<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Orders</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            color: #444;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #444;
            margin-bottom: 20px;
        }
        a {
            color: #57b9ff;
            text-decoration: none;
            margin: 15px;
            font-weight: bold;
        }
        a:hover {
            color: #77b1d4;
        }
        form {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            width: 100%;
            max-width: 400px; /* Ensures the form is not too wide */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            box-sizing: border-box; /* Include padding and border in width */
        }
        form p {
            margin: 10px 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #34495e;
        }
        input[type="text"] {
            width: 100%; /* Full width to prevent overflow */
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Include padding and border in width */
        }
        input[type="submit"] {
            width: 100%; /* Full width */
            padding: 10px;
            margin-top: 10px;
            background-color: #57b9ff;
            color: white;
            cursor: pointer;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #77b1d4;
        }
    </style>
</head>
<body>
    <a href="vieworders.php?customer_id=<?php echo $_GET['customer_id']; ?>">View The Clients</a>
    <h1>Edit Order</h1>
    <?php $getClientByID = getClientByID($pdo, $_GET['order_id']); ?>
    <form action="core/handleForms.php?order_id=<?php echo $_GET['order_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
        <p>
            <label for="firstName">Shirt / Jacket / Pants</label> 
            <input type="text" name="firstName" value="<?php echo $getClientByID['first_name']; ?>" required>
        </p>
        <p>
            <label for="lastName">Size</label> 
            <input type="text" name="lastName" value="<?php echo $getClientByID['last_name']; ?>" required>
        </p>
        <input type="submit" name="editClientBtn" value="Save Changes">
    </form>
</body>
</html>
