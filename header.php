<?php
session_start();
error_reporting(0);
echo <<<_INIT
<!DOCTYPE html> 
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'> 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>

_INIT;

require_once 'functions.php';

$userstr = 'Selamat Datang';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "Logged in as: $user";
} else $loggedin = FALSE;

echo <<<_MAIN
<title>UTS PemWeb IF430 - $userstr </title>
</head>
<body>
<div class="container-fluid">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
<a class="navbar-brand" href="index.php">Sosial Media</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<div class="collapse navbar-collapse" id="navbar">
<ul class="navbar-nav">
_MAIN;

if ($loggedin) {
    echo <<<_LOGGEDIN

<li class="nav-item">
<a class="nav-link" href="members.php?view=$user">Home</a>
</li>
<li class="nav-item">
<a class="nav-link" href="members.php">Members</a>
</li>
<li class="nav-item">
<a class="nav-link" href="friends.php">Friends</a>
</li>
<li class="nav-item">
<a class="nav-link" href="messages.php">Messages</a>
</li>
<li class="nav-item">
<a class="nav-link" href="profile.php">Edit Profile</a>
</li>
<li class="nav-item">
<a class="nav-link" href="logout.php">Log Out</a>
</li>
_LOGGEDIN;
} else {
    echo <<<_GUEST

<li class="nav-item">
<a class="nav-link" href="signup.php">Sign Up</a>
</li>
<li class="nav-item">
<a class="nav-link" href="login.php">Log In</a>
</li>


_GUEST;

}

echo <<<_CLOSINGTAG
</ul>
</div>
</nav>
</div>
_CLOSINGTAG;

?>
