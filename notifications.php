<?php
require_once 'config.php';

// Catch and process the interactive approval request form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'approve_order') {
    $order_id = intval($_POST['order_id']);
    $stmt = $conn->prepare("UPDATE payment_notifications SET status = 'Approved' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
}

$query = "SELECT * FROM payment_notifications ORDER BY submitted_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YT Notes | Payment Audit Console</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #0d1117; color: #f0f6fc; font-family: sans-serif; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .header-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #30363d; padding-bottom: 10px; }
        h1 { font-size: 20px; color: #58a6ff; font-weight: 800; }
        .refresh-btn { background: #21262d; border: 1px solid #30363d; color: #c9d1d9; padding: 6px 12px; border-radius: 4px; font-size: 11px; text-decoration: none; font-weight: bold; }
        .log-card { background-color: #161b22; border: 1px solid #30363d; border-radius: 8px; padding: 15px; margin-bottom: 12px; }
        .log-meta { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 6px; }
        .plan-badge { color: #ffffff; font-weight: bold; }
        .price-badge { color: #56d364; font-weight: 900; }
        .utr-box { background-color: #0d1117; border: 1px solid #30363d; border-radius: 6px; padding: 10px; font-family: monospace; font-size: 13px; color: #ff7b72; word-break: break-all; margin-top: 5px; }
        .timestamp { font-size: 10px; color: #8b949e; text-align: right; margin-top: 8px; }
        
        /* Interactive status badge classes */
        .status-badge { font-size: 10px; font-weight: bold; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; }
        .status-pending { background-color: rgba(241, 225, 166, 0.1); color: #e3b341; border: 1px solid rgba(241, 225, 166, 0.2); }
        .status-approved { background-color: rgba(86, 211, 100, 0.1); color: #56d364; border: 1px solid rgba(86, 211, 100, 0.2); }
        
        .approve-btn { width: 100%; padding: 10px; background-color: #238636; border: 1px solid #2ea44f; border-radius: 6px; color: white; font-weight: bold; font-size: 12px; cursor: pointer; margin-top: 15px; }
        .empty-state { text-align: center; color: #8b949e; font-size: 13px; padding: 40px 20px; background: #161b22; border: 1px dashed #30363d; border-radius: 8px; }
        .nav-link { display: inline-block; margin-top: 15px; font-size: 12px; color: #58a6ff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-bar">
            <h1>🔒 Incoming Payment Logs</h1>
            <a href="notifications.php" class="refresh-btn">🔄 Refresh Audit</a>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php 
                    $current_status = isset($row['status']) ? $row['status'] : 'Pending';
                    $is_pending = ($current_status === 'Pending');
                    $badge_class = $is_pending ? 'status-pending' : 'status-approved';
                ?>
                <div class="log-card">
                    <div class="log-meta">
                        <span class="plan-badge">📦 <?=htmlspecialchars($row['product_name'])?></span>
                        <!-- Renders the dynamic status loop values -->
                        <span class="status-badge <?=$badge_class?>"><?=$current_status?></span>
                    </div>
                    
                    <div style="font-size: 11px; color: #8b949e; margin-top: 8px;">Customer Submitted UTR / TxID:</div>
                    <div class="utr-box"><?=htmlspecialchars($row['transaction_id'])?></div>
                    
                    <div class="log-meta" style="margin-top: 10px; margin-bottom: 0;">
                        <span class="price-badge">$<?=number_format($row['price_paid'], 2)?></span>
                        <span class="timestamp" style="margin:0;">🕒 Logged: <?=htmlspecialchars($row['submitted_at'])?></span>
                    </div>

                    <!-- Interactive dynamic button loop layout -->
                    <?php if ($is_pending): ?>
                        <form action="" method="POST">
                            <input type="hidden" name="action" value="approve_order">
                            <input type="hidden" name="order_id" value="<?=$row['id']?>">
                            <button type="submit" class="approve-btn">Approve & Activate Server</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">📭 No tracking reference logs found yet.</div>
        <?php endif; ?>

        <div style="display: flex; gap: 15px;">
            <a href="index.php" class="nav-link">← Storefront Homepage</a>
            <a href="admin.php" class="nav-link" style="color: #56d364;">⚙️ Fleet Price Settings</a>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>
