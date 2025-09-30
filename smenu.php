<?php
declare(strict_types=1);
/**
 * MCCodes v2 by Dabomstew & ColdBlooded - Heroes vs Villains Theme
 * Staff menu with modern design
 */

if (!defined('JDSF45TJI'))
{
    echo 'This file cannot be accessed directly.';
    die;
}

global $db, $c, $ir, $set;

echo '<nav class="nav-menu">';

echo '<div class="nav-section">';
echo '<div class="nav-title">Staff Panel</div>';
echo "<a href='index.php' class='nav-link'>🏠 Back To Game</a>";
echo "<a href='staff.php' class='nav-link active'>📊 Staff Index</a>";

if (check_access('administrator')) {
    echo "<a href='staff.php?action=basicset' class='nav-link'>⚙️ Basic Settings</a>";
    echo "<a href='staff.php?action=announce' class='nav-link'>📢 Add Announcement</a>";
    echo "<a href='staff.php?action=fire-cron' class='nav-link'>🔄 Fire Cron</a>";
}
echo '</div>';

// Staff Roles Management
if (check_access(['manage_roles', 'manage_staff'])) {
    echo '<div class="nav-section">';
    echo '<div class="nav-title">Staff Roles</div>';
    
    if (check_access('manage_roles')) {
        echo "<a href='staff_roles.php' class='nav-link'>👥 View Staff Roles</a>";
        echo "<a href='staff_roles.php?action=add' class='nav-link'>➕ Create Staff Role</a>";
        echo "<a href='staff_roles.php?action=edit' class='nav-link'>✏️ Edit Staff Role</a>";
        echo "<a href='staff_roles.php?action=remove' class='nav-link'>🗑️ Delete Staff Role</a>";
    }
    
    if (check_access('manage_staff')) {
        echo "<a href='staff_roles.php?action=grant' class='nav-link'>🎖️ Grant Staff Role</a>";
        echo "<a href='staff_roles.php?action=revoke' class='nav-link'>❌ Revoke Staff Role</a>";
    }
    echo '</div>';
}

// User Management
if (check_access(['manage_users', 'view_user_inventory', 'credit_user', 'manage_player_reports', 'credit_all_users', 'manage_items', 'credit_item'])) {
    echo '<div class="nav-section">';
    echo '<div class="nav-title">Users</div>';
    
    if (check_access(['manage_users'])) {
        echo "<a href='staff_users.php?action=newuser' class='nav-link'>👤 Create New User</a>";
        echo "<a href='staff_users.php?action=edituser' class='nav-link'>✏️ Edit User</a>";
        echo "<a href='staff_users.php?action=deluser' class='nav-link'>🗑️ Delete User</a>";
    }
    
    if (check_access('view_user_inventory')) {
        echo "<a href='staff_users.php?action=invbeg' class='nav-link'>🎒 View User Inventory</a>";
    }
    
    if (check_access('credit_user')) {
        echo "<a href='staff_users.php?action=creditform' class='nav-link'>💰 Credit User</a>";
    }
    
    if (check_access('credit_all_users')) {
        echo "<a href='staff_users.php?action=masscredit' class='nav-link'>💸 Mass Payment</a>";
    }
    
    if (check_access('manage_users')) {
        echo "<a href='staff_users.php?action=forcelogout' class='nav-link'>🚪 Force User Logout</a>";
    }
    
    if (check_access('manage_player_reports')) {
        echo "<a href='staff_users.php?action=reportsview' class='nav-link'>🚨 Player Reports</a>";
    }
    echo '</div>';
}

// Items Management
if (check_access(['manage_items', 'credit_item'])) {
    echo '<div class="nav-section">';
    echo '<div class="nav-title">Items</div>';
    
    if (check_access('manage_items')) {
        echo "<a href='staff_items.php?action=newitem' class='nav-link'>🆕 Create New Item</a>";
        echo "<a href='staff_items.php?action=edititem' class='nav-link'>✏️ Edit Item</a>";
        echo "<a href='staff_items.php?action=killitem' class='nav-link'>🗑️ Delete An Item</a>";
        echo "<a href='staff_items.php?action=newitemtype' class='nav-link'>📁 Add Item Type</a>";
    }
    
    echo "<a href='staff_items.php?action=giveitem' class='nav-link'>🎁 Give Item To User</a>";
    echo '</div>';
}

// Logs
if (check_access('view_logs')) {
    echo '<div class="nav-section">';
    echo '<div class="nav-title">Logs</div>';
    echo "<a href='staff_logs.php?action=atklogs' class='nav-link'>⚔️ Attack Logs</a>";
    echo "<a href='staff_logs.php?action=cashlogs' class='nav-link'>💰 Cash Xfer Logs</a>";
    echo "<a href='staff_logs.php?action=cryslogs' class='nav-link'>💎 Crystal Xfer Logs</a>";
    echo "<a href='staff_logs.php?action=banklogs' class='nav-link'>🏦 Bank Xfer Logs</a>";
    echo "<a href='staff_logs.php?action=itmlogs' class='nav-link'>📦 Item Xfer Logs</a>";
    echo "<a href='staff_logs.php?action=maillogs' class='nav-link'>✉️ Mail Logs</a>";
    echo "<a href='staff_logs.php?action=cron-fails' class='nav-link'>⚠️ Cron Fail Logs</a>";
    echo '</div>';
}

// Game Management Sections
$management_sections = [
    'manage_gangs' => [
        'title' => 'Gangs',
        'icon' => '⚔️',
        'links' => [
            'grecord' => 'Gang Record',
            'gcredit' => 'Credit Gang', 
            'gwar' => 'Manage Gang Wars',
            'gedit' => 'Edit Gang'
        ]
    ],
    'manage_shops' => [
        'title' => 'Shops',
        'icon' => '🏪',
        'links' => [
            'newshop' => 'Create New Shop',
            'newstock' => 'Add Item To Shop',
            'delshop' => 'Delete Shop'
        ]
    ],
    'manage_polls' => [
        'title' => 'Polls',
        'icon' => '🗳️',
        'links' => [
            'spoll' => 'Start Poll',
            'endpoll' => 'End A Poll'
        ]
    ],
    'manage_jobs' => [
        'title' => 'Jobs',
        'icon' => '💼',
        'links' => [
            'newjob' => 'Make a new Job',
            'jobedit' => 'Edit a Job',
            'jobdele' => 'Delete a Job',
            'newjobrank' => 'Make a new Job Rank',
            'jobrankedit' => 'Edit a Job Rank',
            'jobrankdele' => 'Delete a Job Rank'
        ]
    ],
    'manage_houses' => [
        'title' => 'Houses',
        'icon' => '🏠',
        'links' => [
            'addhouse' => 'Add House',
            'edithouse' => 'Edit House',
            'delhouse' => 'Delete House'
        ]
    ],
    'manage_cities' => [
        'title' => 'Cities',
        'icon' => '🏙️',
        'links' => [
            'addcity' => 'Add City',
            'editcity' => 'Edit City',
            'delcity' => 'Delete City'
        ]
    ],
    'manage_forums' => [
        'title' => 'Forums',
        'icon' => '💬',
        'links' => [
            'addforum' => 'Add Forum',
            'editforum' => 'Edit Forum',
            'delforum' => 'Delete Forum'
        ]
    ],
    'manage_courses' => [
        'title' => 'Courses',
        'icon' => '📚',
        'links' => [
            'addcourse' => 'Add Course',
            'editcourse' => 'Edit Course',
            'delcourse' => 'Delete Course'
        ]
    ],
    'manage_crimes' => [
        'title' => 'Crimes',
        'icon' => '🔫',
        'links' => [
            'newcrime' => 'Create New Crime',
            'editcrime' => 'Edit Crime',
            'delcrime' => 'Delete Crime',
            'newcrimegroup' => 'Create New Crime Group',
            'editcrimegroup' => 'Edit Crime Group',
            'delcrimegroup' => 'Delete Crime Group',
            'reorder' => 'Reorder Crime Groups'
        ]
    ],
    'manage_challenge_bots' => [
        'title' => 'Battle Tent',
        'icon' => '🤖',
        'links' => [
            'addbot' => 'Add Challenge Bot',
            'editbot' => 'Edit Challenge Bot',
            'delbot' => 'Remove Challenge Bot'
        ]
    ],
    'manage_punishments' => [
        'title' => 'Punishments',
        'icon' => '⚖️',
        'links' => [
            'mailform' => 'Mail Ban User',
            'unmailform' => 'Un-Mailban User',
            'forumform' => 'Forum Ban User',
            'unforumform' => 'Un-Forumban User',
            'fedform' => 'Jail User',
            'fedeform' => 'Edit Fedjail Sentence',
            'unfedform' => 'Unjail User',
            'ipform' => 'IP Search'
        ]
    ]
];

foreach ($management_sections as $permission => $section) {
    if (check_access($permission)) {
        echo '<div class="nav-section">';
        echo "<div class='nav-title'>{$section['icon']} {$section['title']}</div>";
        
        $base_file = match($permission) {
            'manage_gangs' => 'staff_gangs.php',
            'manage_shops' => 'staff_shops.php', 
            'manage_polls' => 'staff_polls.php',
            'manage_jobs' => 'staff_jobs.php',
            'manage_houses' => 'staff_houses.php',
            'manage_cities' => 'staff_cities.php',
            'manage_forums' => 'staff_forums.php',
            'manage_courses' => 'staff_courses.php',
            'manage_crimes' => 'staff_crimes.php',
            'manage_challenge_bots' => 'staff_battletent.php',
            'manage_punishments' => 'staff_punit.php',
            default => 'staff.php'
        };
        
        foreach ($section['links'] as $action => $label) {
            echo "<a href='{$base_file}?action={$action}' class='nav-link'>{$label}</a>";
        }
        echo '</div>';
    }
}

// Special Functions
if (check_access(['edit_newspaper', 'mass_mail', 'manage_staff', 'manage_donator_packs'])) {
    echo '<div class="nav-section">';
    echo '<div class="nav-title">🌟 Special</div>';
    
    if (check_access('edit_newspaper')) {
        echo "<a href='staff_special.php?action=editnews' class='nav-link'>📰 Edit Newspaper</a>";
    }
    if (check_access('mass_mail')) {
        echo "<a href='staff_special.php?action=massmailer' class='nav-link'>📧 Mass Mailer</a>";
    }
    if (check_access('manage_donator_packs')) {
        echo "<a href='staff_special.php?action=givedpform' class='nav-link'>💎 Give User Donator Pack</a>";
    }
    echo '</div>';
}

// Staff Online (for staff panel)
echo '<div class="nav-section">';
echo '<div class="nav-title">Staff Online</div>';
$online_staff = get_online_staff();
foreach ($online_staff as $r) {
    $time_ago = datetime_parse($r['laston']);
    echo "<a href='viewuser.php?u={$r['userid']}' class='nav-link' style='font-size: 12px; padding: 6px 12px;'>{$r['username']} <span class='staff-online'>ONLINE</span></a>";
}

// Time Display
$current_date = date('F j, Y');
$current_time = date('g:i:s a');
echo "<div class='time-display'>";
echo "<div>{$current_date}</div>";
echo "<div>{$current_time}</div>";
echo "</div>";

echo "<a href='logout.php' class='nav-link btn-danger' style='margin-top: 16px;'>🚪 Logout</a>";
echo '</div>';

echo '</nav>';