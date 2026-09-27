<?php
require_once 'config.php';

$message = '';

// Handle Form Submission Data Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_price') {
        $id = intval($_POST['product_id']);
        $new_price = floatval($_POST['price']);
        
        $stmt = $conn->prepare("UPDATE hosting_products SET price = ? WHERE id = ?");
        $stmt->bind_param("di", $new_price, $id);
        if ($stmt->execute()) {
            $message = "✅ Price updated successfully!";
        }
        $stmt->close();
    }
}

// Fetch all current values from the database logs
$query = "SELECT * FROM hosting_products ORDER BY id ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YT Notes | Fleet Management Panel</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            background-color: #0d1117; 
            color: #f0f6fc; 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            padding: 20px;
        }
        .container { max-width: 600px; margin: 0 auto; }
        h1 { font-size: 22px; margin-bottom: 5px; color: #58a6ff; font-weight: 800; }
        .subtitle { font-size: 12px; color: #8b949e; margin-bottom: 20px; }
        
        .alert {
            background-color: rgba(86, 211, 100, 0.1);
            border: 1px solid rgba(86, 211, 100, 0.2);
            color: #56d364;
            padding: 10px;
            border-radius: 6px;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .product-row {
            background-color: #161b22;
            border: 1px solid #30363d;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .product-info { font-size: 14px; font-weight: bold; }
        .product-info span { font-size: 11px; color: #8b949e; font-weight: normal; block; margin-top: 2px;}
        
        .edit-form { display: flex; gap: 8px; align-items: center; width: 100%; }
        .input-box {
            background-color: #0d1117;
            border: 1px solid #30363d;
            color: white;
            padding: 8px;
            border-radius: 4px;
            font-size: 13px;
            width: 100px;
            font-family: monospace;
        }
        .save-btn {
            background-color: #21262d;
            border: 1px solid #30363d;
            color: #c9d1d9;
            padding: 8px 14px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }
        .save-btn:hover { background-color: #30363d; border-color: #8b949e; }
        .nav-link {
            display: inline-block;
            margin-top: 15px;
            font-size: 12px;
            color: #58a6ff;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Node Fleet Management</h1>
        <div class="subtitle">Quick administrative adjustments module engine console.</div>

        <?php if (!empty($message)): ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php 
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="product-row">
                    <div class="product-info">
                        <?php echo htmlspecialchars($row['name']); ?>
                        <span><?php echo htmlspecialchars($row['ram']); ?> / <?php echo htmlspecialchars($row['cpu']); ?></span>
                    </div>
                    
                    <form action="" method="POST" class="edit-form">
                        <input type="hidden" name="action" value="update_price">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <label style="font-size: 12px; color: #8b949e;">Price ($):</label>
                        <input type="number" name="price" step="0.01" class="input-box" value="<?php echo $row['price']; ?>" required>
                        <button type="submit" class="save-btn">Update</button>
                    </form>
                </div>
                <?php
            }
        }
        ?>

        <a href="index.php" class="nav-link">← Return to Storefront Homepage</a>
    </div>

</body>
</html>
<?php $conn->close(); ?>
