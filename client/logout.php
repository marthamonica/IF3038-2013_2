<?php

session_start();

// menghapus session
session_destroy();
header("location: index.php");
?>