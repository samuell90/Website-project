<?php
require_once 'functions.php';

if (isset($_POST['user']))
{
    $user = sanitize_string($_POST['user']);
    $result = query_my_sql("SELECT * FROM members WHERE user='$user'");

    if ($result->num_rows)
        echo "<span>&nbsp;&#x2718; " . "Username '$user' telah diambil</span>";
    else
        echo "<span>&nbsp;&#x2714; " . "Username '$user' tersedia</span>";
}
