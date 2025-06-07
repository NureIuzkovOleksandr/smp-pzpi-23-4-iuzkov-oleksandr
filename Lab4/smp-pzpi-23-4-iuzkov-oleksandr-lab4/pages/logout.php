<?php
session_start();
unset($_SESSION['username'], $_SESSION['auth_timestamp']);
header('Location: /home');
exit;
?>
