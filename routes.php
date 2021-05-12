<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/router.php');

// ##############################
get('/admin', '/views/view_admin.php');

get('/login', '/views/view_login.php');

get('/logout', '/bridges/bridge_logout.php');

get('/profile', '/views/view_profile.php');

get('/signup', '/views/view_signup.php');

get('/users', '/views/view_users.php');


// ##############################¨
post('/deactivate', '/bridges/bridge_deactivate.php');

post('/login', '/bridges/bridge_login.php');

post('/profile', '/bridges/bridge_update_profile.php');

post('/signup', '/bridges/bridge_signup.php');

post('/create-users-table', '/db/db_create_table.php');


// ##############################¨
any('/404', '/views/view_404.php');
