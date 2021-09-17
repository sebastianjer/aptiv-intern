<?php
//belum login
if(!isset($_SESSION['log'])) {
    header('location: login.php');
}

?>