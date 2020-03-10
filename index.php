<?php
require_once 'header.php';
echo "<div class='container'>";
echo "<div>Selamat datang di projek UTS PemWeb,";
if($loggedin) echo " $user, kamu telah masuk";
else echo "silakan daftar atau masuk";

echo <<<_END
</div><br>
<section id="footer">
<footer><h4>Ini adalah projek uts pemweb</h4></footer>
</section>
</div>
_END;
