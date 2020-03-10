<?php
require_once 'header.php';

echo <<<_END
  <script>
    function checkUser(user)
    {
      if (user.value == '')
      {
        $('#used').html('&nbsp;')
        return
      }

      $.post
      (
        'checkuser.php',
        { user : user.value },
        function(data)
        {
          $('#used').html(data)
        }
      )
    }
  </script>  
_END;

$error = $user = $pass = "";
if (isset($_SESSION['user'])) destroy_session();

if (isset($_POST['user'])) {
    $first_name = sanitize_string($_POST['first_name']);
    $last_name = sanitize_string($_POST['last_name']);
    $user = sanitize_string($_POST['user']);
    $birth_date = sanitize_string($_POST['birth_date']);
    $gender = sanitize_string($_POST['gender']);
    $pass = sanitize_string($_POST['pass']);

    if ($user == "" || $pass == "")
        $error = 'Not all fields were entered<br><br>';
    else {
        $result = query_my_sql("SELECT * FROM members WHERE user='$user'");

        if ($result->num_rows)
            $error = 'That username already exists<br><br>';
        else {
            query_my_sql("INSERT INTO members VALUES('$user', '$first_name', '$last_name', '$birth_date', '$gender', '$pass')");
            die('<h4>Account created</h4>Please Log in.');
        }
    }
}
echo <<<_END
<form method='post' action='signup.php'>$error
<div class="form-group">
<h5>Silakan masukan data anda untuk mendaftar</h5>
</div>
<div class="form-group">
<label for="first_name">First Name</label>
<input type="text" name="first_name" value="$first_name" maxlength="20">
</div>
<div class="form-group">
<label for="last_name">Last Name</label>
<input type="text" name="last_name" value="$last_name" maxlength="20">
</div>
<div class="form-group">
<label for="user">Username</label>
<input type="text" name="user" value="$user" onblur="checkUser(this)" maxlength="16">
<div id="used">&nbsp;</div>
</div>
<div class="form-group">
<label for="birth_date">Birth of Date</label>
<input type="date" name="birth_date" value="$birth_date">
</div>
<div class="form-group">
<label for="gender">Gender</label>
<select name="gender" class="custom-select">
<option selected disabled>Pilih jenis kelamin...</option>
<option value="L">Laki-laki</option>
<option value="P">Perempuan</option>
</select>
</div>
<div class="form-group">
<label for="pass">Password</label>
<input type="text" name="pass" value="$pass">
</div>
<button class="btn btn-primary">Daftar</button>
</form>
_END;
