<?php
require_once 'config.php';

$success = false;
$logged_utr = '';
$logged_item = '';

// 1. ONLY process payment details if the user explicitly clicked the final "I Have Paid" button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_utr') {
    $prod_name = $_POST['prod_name'];
    $prod_price = floatval($_POST['prod_price']);
    $utr_number = trim($_POST['transaction_id']);
    
    if (!empty($utr_number)) {
        $stmt = $conn->prepare("INSERT INTO payment_notifications (product_name, price_paid, transaction_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $prod_name, $prod_price, $utr_number);
        if ($stmt->execute()) {
            $success = true;
            $logged_utr = $utr_number;
            $logged_item = $prod_name;
        }
        $stmt->close();
    }
}

// 2. Fetch the plan details from index.php button click (Supports both POST and GET safely)
$id = 0;
if (isset($_POST['selected_product_id'])) {
    $id = intval($_POST['selected_product_id']);
} elseif (isset($_GET['selected_product_id'])) {
    $id = intval($_GET['selected_product_id']);
}

// If no item is selected and we didn't just have a successful checkout, send back home
if ($id === 0 && !$success) {
    header("Location: index.php"); exit();
}

$p = [];
if ($id > 0) {
    $st = $conn->prepare("SELECT * FROM hosting_products WHERE id = ?");
    $st->bind_param("i", $id); $st->execute(); $res = $st->get_result();
    if ($res && $res->num_rows > 0) {
        $p = $res->fetch_assoc();
    }
    $st->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YT Notes | Checkout</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #0d1117; color: #f0f6fc; font-family: sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .box { background: #161b22; border: 1px solid #30363d; border-radius: 12px; padding: 25px; max-width: 440px; width: 100%; text-align: center; }
        h2 { color: #58a6ff; font-size: 20px; margin-bottom: 4px; }
        .sub { font-size: 11px; color: #8b949e; margin-bottom: 20px; }
        .sum { background: #0d1117; border: 1px solid #30363d; border-radius: 8px; padding: 15px; text-align: left; margin-bottom: 20px; }
        .tot { font-size: 20px; font-weight: 900; color: #56d364; border-top: 1px dashed #30363d; padding-top: 10px; margin-top: 10px; }
        .tabs { display: flex; border-bottom: 1px solid #30363d; margin-bottom: 20px; gap: 5px; }
        .tab { flex: 1; padding: 10px; background: none; border: none; color: #8b949e; font-size: 12px; font-weight: bold; cursor: pointer; border-bottom: 2px solid transparent; }
        .tab.act { color: #58a6ff; border-bottom-color: #58a6ff; }
        .panel { display: none; text-align: left; }
        .panel.act { display: block; }
        .form { display: flex; flex-direction: column; gap: 12px; }
        .lbl { font-size: 11px; color: #8b949e; font-weight: bold; }
        .in { background: #0d1117; border: 1px solid #30363d; color: white; padding: 10px; border-radius: 6px; font-size: 13px; width: 100%; outline: none; }
        .in:focus { border-color: #58a6ff; }
        .qr-c { display: flex; flex-direction: column; align-items: center; padding: 15px; background: #0d1117; border: 1px dashed #30363d; border-radius: 8px; text-align: center; }
        .qr-b { width: 260px; height: 320px; background: white; border-radius: 8px; padding: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; }
        .qr-img { width: 100%; height: 100%; object-fit: contain; }
        .btn { width: 100%; padding: 12px; background: #238636; border: 1px solid #2ea44f; border-radius: 6px; color: white; font-weight: bold; font-size: 13px; cursor: pointer; margin-top: 15px; }
        .back { display: block; text-align: center; padding: 12px; background: #21262d; border: 1px solid #30363d; border-radius: 6px; color: #c9d1d9; font-size: 13px; text-decoration: none; margin-top: 10px; }
        .banner { background-color: rgba(86, 211, 100, 0.1); border: 1px solid rgba(86, 211, 100, 0.2); color: #56d364; padding: 15px; border-radius: 8px; font-size: 12px; line-height: 1.5; margin-bottom: 15px; text-align: left; }
    </style>
</head>
<body>
    <div class="box">
        <?php if ($success): ?>
            <!-- SHOW THIS ONLY AFTER A GENUINE FORM SUBMISSION -->
            <h2>Order Sent Successfully!</h2>
            <p class="sub" style="margin-bottom: 15px;">Your transaction verification request has been received.</p>
            <div class="banner">
                🚀 <strong>Payment Reference Logged!</strong><br>
                📦 Plan: <?=htmlspecialchars($logged_item)?><br>
                🔑 Transaction UTR: <code style="background:#0d1117; padding:2px 4px; border-radius:4px;"><?=htmlspecialchars($logged_utr)?></code><br><br>
                Our server team is auditing the tracking ID logs. Your Minecraft node layout configuration instance will boot up automatically upon verification.
            </div>
            <a href="index.php" class="back" style="background:#238636; border-color:#2ea44f; color:white;">Return to Storefront</a>
        <?php else: ?>
            <!-- SHOW THE PROPER PAYMENT SELECTION FIRST -->
            <h2>Secure Checkout</h2>
            <p class="sub">Select a payment method to provision your server node.</p>
            <div class="sum">
                <div style="font-weight:bold; font-size:15px;"><?=htmlspecialchars($p['name'] ?? 'Server Package')?></div>
                <div style="font-size:11px; color:#8b949e; margin:4px 0 10px 0;">💾 <?=($p['ram'] ?? '')?> / ⚙️ <?=($p['cpu'] ?? '')?></div>
                <div class="tot">$<?=number_format($p['price'] ?? 0, 2)?> <span style="font-size:11px; font-weight:normal; color:#8b949e;">/mo</span></div>
            </div>
            <div class="tabs">
                <button class="tab act" onclick="sw('card',this)">💳 Card</button>
                <button class="tab" onclick="sw('qr',this)">📱 QR Code</button>
            </div>
            <div id="card" class="panel act">
                <form action="index.php" method="GET" class="form" onsubmit="alert('🎉 Card Authorized!');">
                    <label class="lbl">Cardholder Name</label><input type="text" class="in" placeholder="John Doe" required>
                    <label class="lbl">Card Number</label><input type="text" class="in" placeholder="4111 2222 3333 4444" required>
                    <div style="display:flex; gap:10px;">
                        <div style="flex:1;"><label class="lbl">Expiry</label><input type="text" class="in" placeholder="MM/YY" required></div>
                        <div style="flex:1;"><label class="lbl">CVV</label><input type="password" class="in" placeholder="123" required></div>
                    </div>
                    <button type="submit" class="btn">Pay with Card</button>
                </form>
            </div>
            <div id="qr" class="panel">
                <div class="qr-c">
                    <div class="qr-b"><img src="qr.png" class="qr-img" alt="Payment QR"></div>
                    <p style="font-size:11px; color:#8b949e; line-height:1.4; margin-bottom:15px;">Scan the code using your bank app to pay <strong>$<?=number_format($p['price'] ?? 0,2)?></strong>.</p>
                    
                    <form action="" method="POST" class="form" style="width:100%;">
                        <input type="hidden" name="action" value="submit_utr">
                        <!-- Remembers the selected product ID to prevent skipping pages -->
                        <input type="hidden" name="selected_product_id" value="<?=$id?>">
                        <input type="hidden" name="prod_name" value="<?=htmlspecialchars($p['name'] ?? '')?>">
                        <input type="hidden" name="prod_price" value="<?=($p['price'] ?? 0)?>">
                        <label class="lbl" style="text-align:left; display:block;">Paste UPI / Bank Transaction ID</label>
                        <input type="text" name="transaction_id" class="in" placeholder="Example: 364910284752" autocomplete="off" required>
                        <button type="submit" class="btn">I Have Paid</button>
                    </form>
                </div>
            </div>
            <a href="index.php" class="back">Cancel & Go Back</a>
        <?php endif; ?>
    </div>
    <script>
        function sw(id, btn) {
            document.querySelectorAll('.panel').forEach(p => p.classList.remove('act'));
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('act'));
            document.getElementById(id).classList.add('act');
            btn.classList.add('act');
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>
