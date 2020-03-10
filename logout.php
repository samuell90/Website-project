<?php
require_once 'header.php';
if (isset($_SESSION['user']))
{
    destroy_session();
    echo "<div class='text-center'>Kamu telah log out. Klik <a href='index.php'>disini</a> untuk kembali ke halaman utama</div>";
}
else echo "<div class='text-center'>Kamu tidak bisa keluar karena kamu belum masuk</div>";
