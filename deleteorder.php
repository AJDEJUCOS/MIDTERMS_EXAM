<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Order</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f7; 
            color: #444; 
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin: 0;
        }

        h1 {
            color: #444; 
            margin-bottom: 20px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            padding: 20px;
            width: 100%;
            max-width: 500px; 
            text-align: left; 
        }

        h2 {
            color: #444; 
            margin: 10px 0; 
        }

        .deleteBtn {
            margin-top: 20px; 
            text-align: right; 
        }

        input[type="submit"] {
            background-color: #57b9ff;
            color: white; 
            border: none; 
            border-radius: 5px; 
            padding: 10px 20px; 
            font-size: 16px; 
            cursor: pointer; 
            transition: background-color 0.3s ease; 
        }

        input[type="submit"]:hover {
            background-color: #77b1d4; 
        }
    </style>
</head>
<body>
    <?php 
    $getClientByID = getClientByID($pdo, $_GET['order_id']); 
    if ($getClientByID): ?>
        <h1>Are you sure you want to delete this order?</h1>
        <div class="container">
            <h2>Clothing: <?php echo $getClientByID['first_name'] ?></h2>
            <h2>Size: <?php echo $getClientByID['last_name'] ?></h2>
            <h2>Client Owner: <?php echo $getClientByID['client_owner'] ?></h2>
            <h2>Date Added: <?php echo $getClientByID['date_added'] ?></h2>

            <div class="deleteBtn">
                <form action="core/handleForms.php?order_id=<?php echo $_GET['order_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
                    <input type="submit" name="deleteClientBtn" value="Delete">
                </form>         
            </div>  
        </div>
    <?php else: ?>
        <h1>Order not found</h1>
        <p>The specified order could not be found. Please check the order ID and try again.</p>
    <?php endif; ?>
</body>
</html>
