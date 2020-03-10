<?php
require_once 'header.php';
$error = $user = $pass = "";
$captcha;

if (isset($_POST['user'])) {
    if(isset($_POST['g-recaptcha-response'])){
        $captcha=$_POST['g-recaptcha-response'];
        if(!$captcha){
            $error = "Please check the captcha form";
        } else{
            $str = "https://www.google.com/recaptcha/api/siteverify?secret=6Lfm6t8UAAAAAFfjoLsBuZ_BNYmoQyJPtL4yPt57"."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'];

            $response = file_get_contents($str);
            $response_arr = (array) json_decode($response);

            if($response_arr['success']==false){
                $error = "You are spammer ! GET OUT";
            }else{
                $user = sanitize_string($_POST['user']);
                $pass = sanitize_string($_POST['pass']);

                if ($user == "" || $pass == "")
                    $error = 'Not all fields were entered';
                else {
                    $result = query_my_sql("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");

                    if ($result->num_rows == 0 ){
                        $error = "Invalid login attempt";
                    } else {
                        $_SESSION['user'] = $user;
                        $_SESSION['pass'] = $pass;
                        die("<div class='text-center'>You are now logged in. Please
                        <a href='members.php?view=$user'>click here</a>
                        to continue.</div>");
                    }
                }
            }
        }
    }  
}

echo <<<_END
<form method='post' action='login.php'>
<div class="form-group">
<span>$error</span>
</div>
<div class="form-group">
<label for="user">Username</label>
<input type="text" name="user" value="$user">
</div>
<div class="form-group">
<label for="pass">Password</label>
<input type="text" name="pass" value="$pass">
</div>
<div class="g-recaptcha" data-sitekey="6Lfm6t8UAAAAAPGoonYnz7Rmpmq5nOXibNfREfT6" style="margin-bottom: 10px;">
</div>
<button class="btn btn-primary">Login</button>
</form>
_END;
