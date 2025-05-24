<?php
session_start();
session_destroy();
header("Location: http://localhost/template-palahesha-pavlo/index.php");
exit();
?>
