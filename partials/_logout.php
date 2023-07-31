<?php
echo "Logging out, Please wait...";
session_start();
session_unset();
session_destroy();
header("location: /forum/index.php?logout=true");
?>