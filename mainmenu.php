<?php
declare(strict_types=1);
/**
 * MCCodes v2 by Dabomstew & ColdBlooded - Heroes vs Villains Theme
 * Modern navigation menu with improved UX
 */

if (!defined('JDSF45TJI'))
{
    echo 'This file cannot be accessed directly.';
    die;
}

global $db, $c, $ir, $set;
$hc = $set['hospital_count'];
$jc = $set['jail_count'];
$ec = $ir['new_events'];
$mc = $ir['new_mail'];

echo '<nav class="nav-menu">';

// Core Navigation
echo '<div class="nav-section">';
echo '<div class="nav-title">Core</div>';

if ($ir['hospital']) {
    echo "<a href='hospital.php' class='nav-link status-hospital'>🏥 Hospital ({$hc})</a>";
    echo "<a href='inventory.php' class='nav-link'>🎒 Inventory</a>";
} elseif ($ir['jail']) {
    echo "<a href='jail.php' class='nav-link status-jail'>🔒 Jail ({$jc})</a>";
} else {
    echo "<a href='index.php' class='nav-link'>🏠 Home</a>";
    echo "<a href='inventory.php' class='nav-link'>🎒 Inventory</a>";
}

echo ($ec > 0) 
    ? "<a href='events.php' class='nav-link notification'>📢 Events ({$ec})</a>"
    : "<a href='events.php' class='nav-link'>📢 Events (0)</a>";

echo ($mc > 0)
    ? "<a href='mailbox.php' class='nav-link notification'>✉️ Mailbox ({$mc})</a>"
    : "<a href='mailbox.php' class='nav-link'>✉️ Mailbox (0)</a>";

echo '</div>';

// Action Navigation
if (!$ir['hospital']) {
    echo '<div class="nav-section">';
    echo '<div class="nav-title">Actions</div>';
    
    if (!$ir['jail']) {
        echo "<a href='explore.php' class='nav-link'>🗺️ Explore</a>";
        echo "<a href='gym.php' class='nav-link'>💪 Gym</a>";
        echo "<a href='criminal.php' class='nav-link'>😈 Crimes</a>";
        echo "<a href='job.php' class='nav-link'>💼 Your Job</a>";
        echo "<a href='education.php' class='nav-link'>🎓 Local School</a>";
    } else {
        echo "<a href='gym.php' class='nav-link'>💪 Jail Gym</a>";
    }
    
    echo "<a href='hospital.php' class='nav-link'>🏥 Hospital ({$hc})</a>";
    echo "<a href='jail.php' class='nav-link'>🔒 Jail ({$jc})</a>";
    echo '</div>';
}

// Community Navigation
echo '<div class="nav-section">';
echo '<div class="nav-title">Community</div>';
echo "<a href='forums.php' class='nav-link'>💬 Forums</a>";

echo ($ir['new_announcements'])
    ? "<a href='announcements.php' class='nav-link notification'>📰 Announcements ({$ir['new_announcements']})</a>"
    : "<a href='announcements.php' class='nav-link'>📰 Announcements (0)</a>";

echo "<a href='newspaper.php' class='nav-link'>📄 Newspaper</a>";
echo "<a href='search.php' class='nav-link'>🔍 Search</a>";

if (!$ir['jail'] && $ir['gang']) {
    echo "<a href='yourgang.php' class='nav-link'>⚔️ Your Gang</a>";
}
echo '</div>';

// Staff Section
if (is_staff()) {
    echo '<div class="nav-section">';
    echo '<div class="nav-title">Staff</div>';
    echo "<a href='staff.php' class='nav-link bg-hero'>🛡️ Staff Panel</a>";
    
    echo '<div style="margin-top: 12px;">';
    echo '<div class="nav-title">Staff Online</div>';
    $online_staff = get_online_staff();
    foreach ($online_staff as $r) {
        $time_ago = datetime_parse($r['laston']);
        echo "<a href='viewuser.php?u={$r['userid']}' class='nav-link' style='font-size: 12px; padding: 6px 12px;'>{$r['username']} <span class='staff-online'>ONLINE</span></a>";
    }
    echo '</div>';
    echo '</div>';
}

// Donator Features
if ($ir['donatordays']) {
    echo '<div class="nav-section">';
    echo '<div class="nav-title">Donator</div>';
    echo "<a href='friendslist.php' class='nav-link'>👥 Friends List</a>";
    echo "<a href='blacklist.php' class='nav-link'>⚫ Black List</a>";
    echo '</div>';
}

// Account Navigation
echo '<div class="nav-section">';
echo '<div class="nav-title">Account</div>';
echo "<a href='preferences.php' class='nav-link'>⚙️ Preferences</a>";
echo "<a href='preport.php' class='nav-link'>🚨 Player Report</a>";
echo "<a href='helptutorial.php' class='nav-link'>❓ Help Tutorial</a>";
echo "<a href='gamerules.php' class='nav-link'>📋 Game Rules</a>";
echo "<a href='viewuser.php?u={$ir['userid']}' class='nav-link'>👤 My Profile</a>";
echo "<a href='logout.php' class='nav-link btn-danger'>🚪 Logout</a>";
echo '</div>';

// Time Display
$current_date = date('F j, Y');
$current_time = date('g:i:s a');
echo "<div class='time-display'>";
echo "<div>{$current_date}</div>";
echo "<div>{$current_time}</div>";
echo "</div>";

echo '</nav>';
    }

    /**
     * @return void
     */
    public function smenuarea(): void
    {
        define('JDSF45TJI', true);
        include 'smenu.php';
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