<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>

<?php
    echo $_SESSION['rol'];
?>

<?php
    require 'views/layout/foot.php';
?>
