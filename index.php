<?php
require_once 'config.php';
$query = "SELECT * FROM hosting_products ORDER BY price ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YT Notes | Premium Server Deployments</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #0d1117; color: #f0f6fc; font-family: sans-serif; padding-bottom: 40px; }
        nav { background-color: #161b22; border-bottom: 1px solid #30363d; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .brand-logo { font-size: 20px; font-weight: 900; color: #58a6ff; }
        .hero { text-align: center; margin: 40px auto; padding: 0 20px; max-width: 600px; }
        .hero h1 { font-size: 28px; font-weight: 800; margin-bottom: 8px; }
        .hero p { font-size: 13px; color: #8b949e; }
        .grid-container { max-width: 1000px; margin: 0 auto; padding: 0 20px; display: flex; flex-direction: column; gap: 20px; }
        @media(min-width: 768px) { .grid-container { flex-direction: row; justify-content: center; } }
        .card { background-color: #161b22; border: 1px solid #30363d; border-radius: 12px; padding: 24px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; position: relative; }
        .card-popular { border: 2px solid #58a6ff; }
        .best-seller-tag { position: absolute; top: 0; right: 20px; transform: translateY(-50%); background-color: #58a6ff; color: #0d1117; font-size: 9px; font-weight: 900; text-transform: uppercase; padding: 2px 8px; border-radius: 10px; }
        .plan-title { font-size: 18px; font-weight: 700; margin-bottom: 2px; }
        .plan-title-pop { color: #58a6ff; }
        .plan-subtitle { font-size: 11px; color: #8b949e; font-style: italic; margin-bottom: 12px; }
        .plan-price { font-size: 28px; font-weight: 900; margin-bottom: 15px; }
        .plan-price span { font-size: 12px; font-weight: normal; color: #8b949e; }
        .specs-list { list-style: none; margin-bottom: 20px; }
        .specs-list li { font-size: 12px; color: #c9d1d9; margin-bottom: 8px; display: flex; align-items: center; }
        .specs-list li::before { content: "🔹"; margin-right: 8px; font-size: 10px; }
        .order-btn { width: 100%; padding: 10px; border: none; border-radius: 6px; font-size: 12px; font-weight: bold; color: #ffffff; background-color: #21262d; border: 1px solid #30363d; cursor: pointer; }
        .order-btn-pop { background-color: #238636; border: 1px solid #2ea44f; }
    </style>
</head>
<body>
    <nav><div class="brand-logo">YT Notes</div></nav>
    <div class="hero">
        <h1>Deploy Your Server Instantly</h1>
        <p>Premium hardware configurations running straight from your database array nodes.</p>
    </div>
    <div class="grid-container">
        <?php 
        if ($result && $result->num_rows > 0) {
            while($server = $result->fetch_assoc()) {
                $is_pop = (bool)$server['is_popular'];
                $card_class = $is_pop ? 'card card-popular' : 'card';
                $title_class = $is_pop ? 'plan-title plan-title-pop' : 'plan-title';
                $btn_class = $is_pop ? 'order-btn order-btn-pop' : 'order-btn';
                ?>
                <div class="<?php echo $card_class; ?>">
                    <?php if ($is_pop): ?><div class="best-seller-tag">Best Seller</div><?php endif; ?>
                    <div>
                        <div class="<?php echo $title_class; ?>"><?php echo htmlspecialchars($server['name']); ?></div>
                        <div class="plan-subtitle"><?php echo htmlspecialchars($server['subtitle']); ?></div>
                        <div class="plan-price">$<?php echo number_format($server['price'], 2); ?> <span>/mo</span></div>
                        <ul class="specs-list">
                            <li><strong><?php echo htmlspecialchars($server['ram']); ?></strong></li>
                            <li><?php echo htmlspecialchars($server['cpu']); ?></li>
                            <li><?php echo htmlspecialchars($server['storage']); ?></li>
                        </ul>
                    </div>
                    <form action="checkout.php" method="POST">
                        <input type="hidden" name="selected_product_id" value="<?php echo $server['id']; ?>">
                        <button type="submit" class="<?php echo $btn_class; ?>">Select Configuration</button>
                    </form>
                </div>
                <?php
            }
        }
        ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>
