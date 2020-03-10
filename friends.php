<?php
require_once 'header.php';

if (!$loggedin) die("<div class='text-center'><h1>Kamu tidak dapat mengakses halaman ini!</h1></div>");

if(isset($_GET['view'])) $view = sanitize_string($_GET['view']);
else $view = $user;

if ($view == $user)
{
    $name1 = $name2 = "Your";
    $name3 = "You are";
}
else
{
    $name1 = "<a href='members.php?view=$view'>$view</a>'s";
    $name2 = "$view's";
    $name3 = "$view is";
}


$followers = array();
$following = array();

$result = query_my_sql("SELECT * FROM friends WHERE user='$view'");
$num = $result->num_rows;

for($i=0; $i<0; ++$i)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $followers[$i] = $row['friend'];
}

$result = query_my_sql("SELECT * FROM friends WHERE friend='$view'");
$num = $result->num_rows;

for($i=0; $i<0; ++$i)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $following[$i] = $row['user'];
}

$mutual = array_intersect($followers, $following);
$followers = array_diff($followers, $mutual);
$following = array_diff($following, $mutual);
$friends = FALSE;

echo "<br>";

if (sizeof($mutual))
{
    echo "<span >$name2 mutual friends</span><ul>";
    foreach($mutual as $friend)
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
}

if (sizeof($followers))
{
    echo "<span>$name2 followers</span><ul>";
    foreach($followers as $friend)
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
}

if (sizeof($following))
{
    echo "<span>$name3 following</span><ul>";
    foreach($following as $friend)
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
}

if (!$friends) echo "<br>Kamu belum memiliki teman!";

