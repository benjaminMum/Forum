<?php 
    function view_home() {
        ob_start();
        $title = "Page principale"
?>



<?php

    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_home()
    }

?>