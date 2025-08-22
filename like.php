<?php
// like_bot_bd.php
$uid_file = 'uids.txt';

// Handle UID addition
if(isset($_POST['add_uid'])){
    $new_uid = trim($_POST['uid']);
    if($new_uid){
        $uids = file_exists($uid_file) ? file($uid_file, FILE_IGNORE_NEW_LINES) : [];
        if(!in_array($new_uid, $uids)){
            $uids[] = $new_uid;
            file_put_contents($uid_file, implode("\n", $uids));
            $msg = "UID added successfully!";
        } else {
            $msg = "UID already exists!";
        }
    }
}

// Read saved UIDs
$uids = file_exists($uid_file) ? file($uid_file, FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Free Fire Like Bot (BD)</title>
<style>
body { font-family: Arial; background:#f0f0f0; margin:0; padding:0; }
.container { max-width:500px; margin:auto; background:#fff; padding:20px; border-radius:10px; margin-top:20px; }
input[type=text], button { width:100%; padding:10px; margin:5px 0; border-radius:5px; border:1px solid #ccc; }
button { border:none; background:#28a745; color:#fff; font-size:16px; }
button:hover { background:#218838; cursor:pointer; }
ul { list-style:none; padding:0; }
li { background:#e9ecef; margin:5px 0; padding:10px; border-radius:5px; word-break:break-word; }
.msg { text-align:center; padding:10px; border-radius:5px; margin-bottom:10px; }
.success { background:#d4edda; color:#155724; }
.warning { background:#fff3cd; color:#856404; }
</style>
</head>
<body>
<div class="container">
<h2 style="text-align:center;">Free Fire Like Bot (BD)</h2>

<?php if(isset($msg)): ?>
<div class="msg <?= ($msg=="UID added successfully!"?'success':'warning') ?>"><?= $msg ?></div>
<?php endif; ?>

<!-- Add UID Form -->
<form method="POST">
<input type="text" name="uid" placeholder="Enter UID" required>
<button type="submit" name="add_uid">Add UID</button>
</form>

<!-- Saved UIDs List -->
<h3>Saved UIDs:</h3>
<ul>
<?php foreach($uids as $uid): ?>
<li><?= htmlspecialchars($uid) ?></li>
<?php endforeach; ?>
</ul>

<!-- Run API Sequentially -->
<form method="POST">
<button type="submit" name="run_api" style="background:#007bff;">Run API Sequentially (BD)</button>
</form>

<?php
if(isset($_POST['run_api']) && !empty($uids)){
    echo "<h3>Results:</h3><ul>";
    foreach($uids as $uid){
        flush(); ob_flush(); // Realtime output
        $api_url = "https://arisha-s-like-bot.vercel.app/like?uid=$uid&server_name=BD";
        $response = @file_get_contents($api_url);
        if($response){
            echo "<li>UID $uid: ".htmlspecialchars($response)."</li>";
        } else {
            echo "<li>UID $uid: API call failed.</li>";
        }
        // Optional delay to avoid rate-limit
        // sleep(1);
    }
    echo "</ul>";
}
?>
</div>
</body>
</html>
