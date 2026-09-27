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
    <title>YT Notes | Intel Xeon Core Fleet</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #0d1117; color: #f0f6fc; font-family: sans-serif; padding-bottom: 60px; }
        nav { background-color: #161b22; border-bottom: 1px solid #30363d; padding: 15px 20px; text-align: center; }
        .logo { font-size: 22px; font-weight: 900; color: #58a6ff; }
        
        .hero { text-align: center; margin: 40px auto; padding: 0 20px; max-w: 650px; }
        .hero h1 { font-size: 26px; font-weight: 800; color: #ffffff; margin-bottom: 6px; }
        .hero p { font-size: 13px; color: #8b949e; line-height: 1.4; }

        /* Grid Layout supporting 9 dynamic cards on mobile */
        .grid { max-width: 1100px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        
        .card { background-color: #161b22; border: 1px solid #30363d; border-radius: 12px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; position: relative; }
        .card-pop { border: 2px solid #58a6ff; box-shadow: 0 0 15px rgba(88,166,255,0.1); }
        .pop-tag { position: absolute; top: 0; right: 20px; transform: translateY(-50%); background: #58a6ff; color: #0d1117; font-size: 9px; font-weight: 900; padding: 2px 8px; border-radius: 10px; text-transform: uppercase; }

        .name { font-size: 16px; font-weight: 800; color: #ffffff; }
        .price { font-size: 24px; font-weight: 900; color: #56d364; margin: 10px 0; }
        .price span { font-size: 12px; color: #8b949e; font-weight: normal; }
        
        .specs { list-style: none; margin-bottom: 20px; border-top: 1px dashed #30363d; padding-top: 12px; }
        .specs li { font-size: 12px; color: #c9d1d9; margin-bottom: 6px; }
        
        .btn { width: 100%; padding: 10px; border: none; border-radius: 6px; font-size: 12px; font-weight: bold; color: white; background: #21262d; border: 1px solid #30363d; cursor: pointer; transition: 0.2s; }
        .btn-pop { background: #238636; border-color: #2ea44f; }
        .btn:hover { opacity: 0.9; }

        /* Custom Resources Addon Calculator Box Layout CSS */
        .calculator-box { max-width: 600px; margin: 40px auto 0 auto; background: #161b22; border: 1px dashed #58a6ff; border-radius: 12px; padding: 25px; text-align: center; }
        .calc-title { font-size: 16px; font-weight: bold; color: #58a6ff; margin-bottom: 15px; }
        .slider-group { margin-bottom: 15px; text-align: left; }
        .slider-lbl { display: flex; justify-content: space-between; font-size: 12px; color: #8b949e; margin-bottom: 5px; }
        .range-in { width: 100%; accent-color: #58a6ff; background: #0d1117; cursor: pointer; }
        .calc-total { font-size: 20px; font-weight: 900; color: #56d364; border-top: 1px solid #30363d; padding-top: 12px; margin-top: 15px; }
    </style>
</head>
<body>

    <nav><div class="logo">YT Notes Node Fleet</div></nav>

    <div class="hero">
        <h1>🚀 Powered by Intel Xeon E5-2699 v4</h1>
        <p>Cost-effective, secure, and reliable server hosting nodes. The absolute perfect architecture choice for starting up smooth SMP networks with friends!</p>
    </div>

    <!-- CARDS GENERATION GRID BLOCK CONTAINER -->
    <div class="grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($s = $result->fetch_assoc()): ?>
                <?php 
                    $pop = (bool)$s['is_popular']; 
                    $c_style = $pop ? 'card card-pop' : 'card';
                    $b_style = $pop ? 'btn btn-pop' : 'btn';
                ?>
                <div class="<?=$c_style?>">
                    <?php if ($pop): ?><div class="pop-tag">Best Value</div><?php endif; ?>
                    <div>
                        <div class="name"><?=htmlspecialchars($s['name'])?></div>
                        <div class="price">₹<?=number_format($s['price'], 0)?> <span>/mo</span></div>
                        <ul class="specs">
                            <li>🔷 <strong>RAM:</strong> <?=htmlspecialchars($s['ram'])?></li>
                            <li>🔷 <strong>Storage:</strong> <?=htmlspecialchars($s['storage'])?></li>
                            <li>🔷 <strong>CPU:</strong> <?=htmlspecialchars($s['cpu'])?></li>
                            <li>🔷 Instant Automated Deployment</li>
                        </ul>
                    </div>
                    <form action="checkout.php" method="POST">
                        <input type="hidden" name="selected_product_id" value="<?=$s['id']?>">
                        <button type="submit" class="<?=$b_style?>">Select Node</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- ADDON EXTRAS LIVE PRICING INTERACTIVE SLIDER ENGINE -->
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
        // Real-time JavaScript arithmetic slider calculations engine
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
<?php $conn->close(); ?>
