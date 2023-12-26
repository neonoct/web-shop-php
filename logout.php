<?php
//logs out the user
//destroys the session
function logout() {
    session_start();
    session_destroy();
    header("Location: index.php");
    exit();
}

logout();


?>