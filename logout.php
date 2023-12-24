<?php
//logs out the user
//destroys the session
session_start();
session_destroy();
header("Location: index.php");
exit();


?>