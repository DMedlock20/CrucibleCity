<?php
declare(strict_types=1);
/**
 * MCCodes v2 by Dabomstew & ColdBlooded - Heroes vs Villains Theme
 * Modern login page design
 */

global $db, $set;
require_once('globals_nonauth.php');
$IP = str_replace(['/', '\\', '\0'], '', $_SERVER['REMOTE_ADDR']);

if (file_exists('ipbans/' . $IP)) {
    die("<div style='color: #ef4444; text-align: center; padding: 20px;'>Your IP has been banned from {$set['game_name']}, there is no way around this.</div></body></html>");
}

$login_csrf = request_csrf_code('login');

echo <<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$set['game_name']} - Heroes vs Villains</title>
    <link href="css/login.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="{$set['jquery_location']}"></script>
    <script type="text/javascript" src="js/login.js"></script>
</head>
<body onload="getme();">

<div class="login-container">
    <div class="login-header">
        <div class="game-logo">Heroes vs Villains</div>
        <div class="game-subtitle">{$set['game_name']}</div>
    </div>
    
    <form name="login" action="authenticate.php" method="post" onsubmit="return saveme();">
        <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Remember Me</label>
            <div style="display: flex; gap: 16px;">
                <label style="display: flex; align-items: center; gap: 6px;">
                    <input type="radio" name="save" value="1"> Yes
                </label>
                <label style="display: flex; align-items: center; gap: 6px;">
                    <input type="radio" name="save" value="0" checked> No
                </label>
            </div>
        </div>
        
        <input type="hidden" name="verf" value="{$login_csrf}" />
        <button type="submit" class="btn btn-primary">🚀 Enter Game</button>
    </form>
    
    <div class="login-footer">
        <a href="register.php">Create New Account</a>
    </div>
</div>

<div style="position: fixed; bottom: 16px; left: 50%; transform: translateX(-50%); background: var(--neutral-surface); padding: 12px 20px; border-radius: 8px; border: 1px solid var(--neutral-border); text-align: center; max-width: 500px;">
    <div style="color: var(--text-secondary); margin-bottom: 8px;">{$set['game_description']}</div>
    <div style="color: var(--text-muted); font-size: 12px;">Choose your side: Hero or Villain</div>
</div>

</body>
</html>
EOF;