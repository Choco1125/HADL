<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>

<div class="container">
    <div class="row-justify-content-center">
        <div class="jumbotron mt-5">
            <h1 class="display-4">¡Bienvenido Usuario!</h1>
        </div>
    </div>
</div>

<?php
    require 'views/layout/foot.php';
?>
