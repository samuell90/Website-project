<?php
require_once 'header.php';

if (!$loggedin) die("<div class='text-center'><h1>Kamu tidak dapat mengakses halaman ini!</h1></div>");

if (isset($_GET['view'])) {
    $view = sanitize_string($_GET['view']);
    if ($view == $user) $name = "Your";
    else $name = "$view's";

    echo "<h3>Profil $name</h3>";
    show_profile($view);
    echo "<button><a href='messages.php?view=$view'>Lihat pesan</a></button>";
}

if (isset($_GET['add'])) {
    $add = sanitize_string($_GET['add']);

    $result = query_my_sql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
        query_my_sql("INSERT INTO friends VALUES('$add', '$user')");
} elseif (isset($_GET['remove'])) {
    $remove = sanitize_string($_GET['remove']);
    query_my_sql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}

$result = query_my_sql("SELECT user FROM members ORDER BY user");
$num = $result->num_rows;

echo "<h3>Anggota lainnya</h3><ul>";
for ($i = 0; $i < $num; ++$i) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;

    echo "<li><a  href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = query_my_sql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
    $t1 = $result1->num_rows;
    $result1 = query_my_sql("SELECT * FROM friends WHERE user='$user' AND friend='" . $row['user'] . "'");
    $t2 = $result1->num_rows;

    if (($t1 + $t2) > 1) echo " &harr; is a mutual friend";
    elseif ($t1) echo " &larr; you are following";
    elseif ($t2) {
        echo " &rarr; is following you";
        $follow = "recip";
    }

    if (!$t1) echo " [<a href='members.php?add=" . $row['user'] . "'>$follow</a>]";
    else      echo " [<a href='members.php?remove=" . $row['user'] . "'>drop</a>]";


}
echo "</ul>";
