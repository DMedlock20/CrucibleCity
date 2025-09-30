<?php
declare(strict_types=1);

/**
 * MCCodes Version 2.0.5b - Heroes vs Villains Theme
 * Modern redesign with three-column layout
 */

class headers
{
    /**
     * @return void
     */
    public function startheaders(): void
    {
        global $set;
        echo <<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$set['game_name']} - Heroes vs Villains</title>
    <link href="css/game.css" type="text/css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
<div class="game-container">
EOF;
    }

    /**
     * @param $ir
     * @param $lv
     * @param $fm
     * @param $cm
     * @param int $dosessh
     * @return void
     */
    public function userdata($ir, $lv, $fm, $cm, int $dosessh = 1): void
    {
        global $db, $userid, $set;
        $IP = $db->escape($_SERVER['REMOTE_ADDR']);
        $db->query(
            "UPDATE `users`
                 SET `laston` = {$_SERVER['REQUEST_TIME']}, `lastip` = '$IP'
                 WHERE `userid` = $userid");
        
        if (!$ir['email']) {
            global $domain;
            die("<body>Your account may be broken. Please mail help@{$domain} stating your username and player ID.");
        }
        
        if (!isset($_SESSION['attacking'])) {
            $_SESSION['attacking'] = 0;
        }
        
        if ($dosessh && ($_SESSION['attacking'] || $ir['attacking'])) {
            echo 'You lost all your EXP for running from the fight.';
            $db->query(
                "UPDATE `users`
                     SET `exp` = 0, `attacking` = 0
                     WHERE `userid` = $userid");
            $_SESSION['attacking'] = 0;
        }

        // Calculate percentages for progress bars
        $enperc = min((int)($ir['energy'] / $ir['maxenergy'] * 100), 100);
        $wiperc = min((int)($ir['will'] / $ir['maxwill'] * 100), 100);
        $experc = min((int)($ir['exp'] / $ir['exp_needed'] * 100), 100);
        $brperc = min((int)($ir['brave'] / $ir['maxbrave'] * 100), 100);
        $hpperc = min((int)($ir['hp'] / $ir['maxhp'] * 100), 100);

        $donator_badge = $ir['donatordays'] ? '<span class="donator-badge">DONATOR</span>' : '';
        $player_name_class = $ir['donatordays'] ? 'text-warning' : '';

        echo <<<EOF
    <header class="game-header">
        <div class="game-logo">Heroes vs Villains</div>
        <div class="game-title">{$set['game_name']}</div>
        <a href="logout.php" class="emergency-logout">Emergency Logout</a>
    </header>

    <aside class="sidebar sidebar-left">
        <div class="player-info">
            <div class="player-name {$player_name_class}">
                {$ir['username']} 
                <span class="player-id">[{$ir['userid']}]</span>
                {$donator_badge}
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-label">Money</span>
                <span class="stat-value">{$fm}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Level</span>
                <span class="stat-value">{$ir['level']}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Crystals</span>
                <span class="stat-value">{$ir['crystals']}</span>
            </div>
        </div>

        <div class="progress-container">
            <div class="progress-item">
                <div class="progress-label">
                    <span>Energy</span>
                    <span>{$enperc}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill progress-energy" style="width: {$enperc}%"></div>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-label">
                    <span>Will</span>
                    <span>{$wiperc}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill progress-will" style="width: {$wiperc}%"></div>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-label">
                    <span>Brave</span>
                    <span>{$ir['brave']}/{$ir['maxbrave']}</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill progress-brave" style="width: {$brperc}%"></div>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-label">
                    <span>Experience</span>
                    <span>{$experc}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill progress-exp" style="width: {$experc}%"></div>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-label">
                    <span>Health</span>
                    <span>{$hpperc}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill progress-health" style="width: {$hpperc}%"></div>
                </div>
            </div>
        </div>
EOF;

        if ($ir['fedjail'] > 0) {
            $q = $db->query("SELECT * FROM `fedjail` WHERE `fed_userid` = $userid");
            $r = $db->fetch_row($q);
            die("<div class='card'><div class='status-jail'>You have been put in the {$set['game_name']} Federal Jail for {$r['fed_days']} day(s).<br />Reason: {$r['fed_reason']}</div></div></body></html>");
        }
        
        if (file_exists('ipbans/' . $IP)) {
            die("<div class='card'><div class='status-jail'>Your IP has been banned from {$set['game_name']}, there is no way around this.</div></div></body></html>");
        }
    }

    /**
     * @return void
     */
    public function menuarea(): void
    {
        define('JDSF45TJI', true);
        include 'mainmenu.php';
        global $ir, $set;
        
        echo '</aside>';
        echo '<main class="main-content">';
        
        if ($ir['hospital']) {
            echo "<div class='card'><div class='status-hospital'>⚕️ You are currently in hospital for {$ir['hospital']} minutes.</div></div>";
        }
        if ($ir['jail']) {
            echo "<div class='card'><div class='status-jail'>🔒 You are currently in jail for {$ir['jail']} minutes.</div></div>";
        }
        
        echo "<div class='card'><div class='text-center'><a href='donator.php' class='btn btn-primary'>💎 Donate to {$set['game_name']} for game benefits!</a></div></div>";
    }

    /**
     * @return void
     */
    public function smenuarea(): void
    {
        define('JDSF45TJI', true);
        include 'smenu.php';
        echo '</aside>';
        echo '<main class="main-content">';
    }

    /**
     * @return void
     */
    public function endpage(): void
    {
        global $db;
        $query_extra = '';
        if (isset($_GET['mysqldebug']) && check_access('administrator')) {
            $query_extra = '<br />' . implode('<br />', $db->queries);
        }
        
        echo <<<EOF
    </main>
    
    <aside class="sidebar sidebar-right">
        <div>Future content area</div>
    </aside>
</div>

<div style="position: fixed; bottom: 16px; right: 16px; background: var(--neutral-surface); padding: 8px 12px; border-radius: 6px; font-size: 12px; color: var(--text-muted); border: 1px solid var(--neutral-border);">
    {$db->num_queries} queries{$query_extra}
</div>

</body>
</html>
EOF;
    }
}