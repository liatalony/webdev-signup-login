<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/router.php');

// ##############################
get('/', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_index.php');
});

// ##############################
get('/admin', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_admin.php');
});

// ##############################
get('/login', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_login.php');
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

post('/login', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_login.php');
});

post('/signup', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_signup.php');
});

post('/users/create', function () {
  echo 'user created';
});

// ##############################
post('/users/update/:id', function ($id) {
  echo "Updating user with id: $id";
});

// ##############################
post('/users/delete/:user_id', function ($user_id) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/apis/api_delete_user.php');
});


// ##############################
post('/db-create-table', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_create_table.php');
});

// ##############################
post('/db-seed-users', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db_seed_users.php');
});


// For GET or POST
any('/404', function () {
  echo 'Not found';
});
