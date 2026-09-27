<?php
require_once 'config.php';
// Pull the new 9-tier Intel Xeon configurations from your cloud database cluster
$query = "SELECT * FROM hosting_products ORDER BY price ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YT Notes | Intel Xeon Core Fleet</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            background-color: #0d1117; 
            color: #f0f6fc; 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            padding-bottom: 60px;
        }
        nav {
            background-color: #161b22;
            border-bottom: 1px solid #30363d;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-logo { font-size: 20px; font-weight: 900; letter-spacing: 1px; color: #58a6ff; }
        .brand-tag { font-size: 10px; background-color: #21262d; padding: 4px 8px; border-radius: 4px; color: #8b949e; font-weight: bold; }
        .hero { text-align: center; margin: 40px auto; padding: 0 20px; max-width: 650px; }
        .hero h1 { font-size: 26px; font-weight: 800; color: #ffffff; margin-bottom: 8px; }
        .hero p { font-size: 13px; color: #8b949e; line-height: 1.5; }

        .stack-container { max-width: 700px; margin: 0 auto; padding: 0 20px; display: flex; flex-direction: column; gap: 20px; }
        .card { background-color: #161b22; border: 1px solid #30363d; border-radius: 12px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; position: relative; transition: 0.2s; }
        .card:hover { border-color: #388bfd; }
        .card-popular { border: 2px solid #58a6ff; box-shadow: 0 0 20px rgba(88, 166, 255, 0.15); }
        .best-seller-tag { position: absolute; top: 0; right: 24px; transform: translateY(-50%); background-color: #58a6ff; color: #0d1117; font-size: 9px; font-weight: 900; text-transform: uppercase; padding: 3px 10px; border-radius: 12px; letter-spacing: 0.5px; }

        .card-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
        .plan-title { font-size: 20px; font-weight: 800; color: #ffffff; }
        .plan-title-pop { color: #58a6ff; }
        .plan-subtitle { font-size: 11px; color: #8b949e; font-style: italic; margin-top: 2px; }
        .plan-price { font-size: 26px; font-weight: 900; color: #56d364; text-align: right; }
        .plan-price span { font-size: 12px; font-weight: normal; color: #8b949e; }

        .specs-list { list-style: none; margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; border-top: 1px dashed #30363d; padding-top: 15px; }
        @media(max-width: 480px) { .specs-list { grid-template-columns: 1fr; } }
        .specs-list li { font-size: 12px; color: #c9d1d9; display: flex; align-items: center; }
        .specs-list li::before { content: "🔹"; margin-right: 8px; font-size: 10px; }

        .order-btn { width: 100%; padding: 12px; border: none; border-radius: 6px; font-size: 13px; font-weight: bold; color: #ffffff; background-color: #21262d; border: 1px solid #30363d; cursor: pointer; transition: 0.2s; text-align: center; }
        .order-btn-pop { background-color: #238636; border: 1px solid #2ea44f; }
        .order-btn:hover { opacity: 0.95; background-color: #30363d; }
        .order-btn-pop:hover { background-color: #2ea44f; }

        .calculator-box { max-width: 700px; margin: 40px auto 0 auto; background: #161b22; border: 1px dashed #58a6ff; border-radius: 12px; padding: 25px; text-align: center; }
        .calc-title { font-size: 16px; font-weight: bold; color: #58a6ff; margin-bottom: 15px; }
        .slider-group { margin-bottom: 15px; text-align: left; }
        .slider-lbl { display: flex; justify-content: space-between; font-size: 12px; color: #8b949e; margin-bottom: 5px; }
        .range-in { width: 100%; accent-color: #58a6ff; background: #0d1117; cursor: pointer; }
        .calc-total { font-size: 20px; font-weight: 900; color: #56d364; border-top: 1px solid #30363d; padding-top: 12px; margin-top: 15px; }
    </style>
</head>
<body>

    <nav>
        <div class="brand-logo">YT Notes</div>
        <div class="brand-tag">XEON FLEET LAYER</div>
    </nav>

    <div class="hero">
        <h1>🚀 Powered by Intel Xeon E5-2699 v4</h1>
        <p>Cost-effective, secure, and reliable hardware architecture nodes. Perfect for starting high-performance community servers with zero baseline lag configurations!</p>
    </div>

    <div class="stack-container">
        <?php 
        if ($result && $result->num_rows > 0) {
            while($server = $result->fetch_assoc()) {
                $is_pop = (bool)$server['is_popular'];
                $card_class = $is_pop ? 'card card-popular' : 'card';
                $title_class = $is_pop ? 'plan-title plan-title-pop' : 'plan-title';
                $btn_class = $is_pop ? 'order-btn order-btn-pop' : 'order-btn';
                ?>
                <div class="<?php echo $card_class; ?>">
                    <?php if ($is_pop): ?>
                        <div class="best-seller-tag">Most Popular</div>
                    <?php endif; ?>
                    <div>
                        <div class="card-header-row">
                            <div>
                                <div class="<?php echo $title_class; ?>"><?php echo htmlspecialchars($server['name']); ?></div>
                                <div class="plan-subtitle"><?php echo htmlspecialchars($server['subtitle']); ?></div>
                            </div>
                            <div class="plan-price">₹<?php echo number_format($server['price'], 0); ?> <span>/mo</span></div>
                        </div>
                        <ul class="specs-list">
                            <li><strong>RAM:</strong>&nbsp;<?php echo htmlspecialchars($server['ram']); ?></li>
                            <li><strong>CPU:</strong>&nbsp;<?php echo htmlspecialchars($server['cpu']); ?></li>
                            <li><strong>Storage:</strong>&nbsp;<?php echo htmlspecialchars($server['storage']); ?></li>
                            <li>Enterprise Anti-DDoS Node Shield</li>
                        </ul>
                    </div>
                    <form action="checkout.php" method="POST">
                        <input type="hidden" name="selected_product_id" value="<?php echo $server['id']; ?>">
                        <button type="submit" class="<?php echo $btn_class; ?>">Select Plan Configuration</button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo "<p style='text-align:center; font-size:12px; color:#8b949e; padding:4px;'>No hosting config matrices loaded active.</p>";
        }
        ?>
    </div>

    <div class="calculator-box">
        <div class="calc-title">🛠️ Customize Extras Configuration Module</div>
        <p style="font-size:11px; color:#8b949e; margin-bottom:20px;">Starting at just ₹30 for every extra 1 GB RAM, 100% CPU Core, or 20 GB Storage allotment fields.</p>
        
        <div class="slider-group">
            <div class="slider-lbl"><span>Extra RAM allotment</span><span id="ram-val">0 GB (+₹0)</span></div>
            <input type="range" id="ram-slider" min="0" max="32" value="0" class="range-in" oninput="calculateExtras()">
        </div>
        <div class="slider-group">
            <div class="slider-lbl"><span>Extra CPU Processing Performance</span><span id="cpu-val">0% (+₹0)</span></div>
            <input type="range" id="cpu-slider" min="0" max="800" step="100" value="0" class="range-in" oninput="calculateExtras()">
        </div>
        <div class="slider-group">
            <div class="slider-lbl"><span>Extra NVMe Solid State Storage</span><span id="disk-val">0 GB (+₹0)</span></div>
            <input type="range" id="disk-slider" min="0" max="500" step="20" value="0" class="range-in" oninput="calculateExtras()">
        </div>
        <div class="calc-total">
            Estimated Extras Total: <span id="total-cost">₹0</span> <span style="font-size:11px; font-weight:normal; color:#8b949e;">/mo addon</span>
        </div>
    </div>

    <script>
        function calculateExtras() {
            var ram = parseInt(document.getElementById('ram-slider').value);
            var cpu = parseInt(document.getElementById('cpu-slider').value) / 100;
            var disk = parseInt(document.getElementById('disk-slider').value) / 20;
            
            var ramCost = ram * 30;
            var cpuCost = cpu * 30;
            var diskCost = disk * 30;
            var total = ramCost + cpuCost + diskCost;
            
            document.getElementById('ram-val').innerText = ram + " GB (+₹" + ramCost + ")";
            document.getElementById('cpu-val').innerText = (cpu * 100) + "% (+₹" + cpuCost + ")";
            document.getElementById('disk-val').innerText = (disk * 20) + " GB (+₹" + diskCost + ")";
            document.getElementById('total-cost').innerText = "₹" + total;
        }
    </script>
</body>
</html>
