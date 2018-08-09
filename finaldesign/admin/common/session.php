<?php
if(!isset($_SESSION['id'])){
    echo '<script>location.href="login2.php?action=logout";</script>';
    exit();
}
?>