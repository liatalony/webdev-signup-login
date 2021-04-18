<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/router.php');

// ##############################
get('/admin', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_admin.php');
});

// ##############################
get('/login', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_login.php');
});

// ##############################
get('/logout', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_logout.php');
});

// ##############################
get('/signup', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_signup.php');
});

// ##############################
get('/users', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_users.php');
});



// ##############################
// ##############################
// ##############################¨

post('/deactivate', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_deactivate.php');
});

post('/login', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_login.php');
});

post('/signup', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_signup.php');
});

// For GET or POST
any('/404', function () {
  echo 'Not found';
});
