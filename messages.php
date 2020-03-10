<?php
require_once 'header.php';

echo "<div class='container'>";
if (!$loggedin) die("<div class='text-center'><h1>Kamu tidak dapat mengakses halaman ini!</h1></div>");

if (isset($_GET['view'])) $view = sanitize_string($_GET['view']);
else                      $view = $user;

if (isset($_POST['text']))
{
    $text = sanitize_string($_POST['text']);

    if ($text != "")
    {
        $pm   = substr(sanitize_string($_POST['pm']),0,1);
        $time = time();
        query_my_sql("INSERT INTO messages VALUES(NULL, '$user',
        '$view', '$pm', $time, '$text')");
    }
}

if ($view != "")
{
    if ($view == $user) $name1 = $name2 = "Your";
    else
    {
        $name1 = "<a href='members.php?view=$view'>$view</a>'s";
        $name2 = "$view's";
    }

    echo "<h3>$name1 Messages</h3>";
    show_profile($view);

    echo <<<_END
    <div style="padding-left:1px;">
      <form method='post' action='messages.php?view=$view'>
        <fieldset >
          <legend>Type here to leave a message</legend>
          <input type='radio' name='pm' id='public' value='0' checked='checked'>
          <label for="public">Public</label>
          <input type='radio' name='pm' id='private' value='1'>
          <label for="private">Private</label>
        </fieldset>
      <textarea name='text' style="padding-left:600px; padding-bottom:100px;"></textarea><br>
      <input style="margin-left:660px;" type='submit' value='Post Message'>
    </form><br>
    </div>
_END;

    date_default_timezone_set('UTC');

    if (isset($_GET['erase']))
    {
        $erase = sanitize_string($_GET['erase']);
        query_my_sql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
    }

    $query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
    $result = query_my_sql($query);
    $num    = $result->num_rows;

    for ($j = 0 ; $j < $num ; ++$j)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
        {
            echo date('M jS \'y g:ia:', $row['time']);
            echo " <a href='messages.php?view=" . $row['auth'] .
                "'>" . $row['auth']. "</a> ";

            if ($row['pm'] == 0)
                echo "wrote: &quot;" . $row['message'] . "&quot; ";
            else
                echo "whispered: <span class='whisper'>&quot;" .
                    $row['message']. "&quot;</span> ";

            if ($row['recip'] == $user)
                echo "[<a href='messages.php?view=$view" .
                    "&erase=" . $row['id'] . "'>erase</a>]";

            echo "<br>";
        }
    }
}

if (!$num)
    echo "<br><span class='info'>No messages yet</span><br><br>";

echo "<br><a href='messages.php?view=$view'>Refresh messages</a>";
echo "</div>";
