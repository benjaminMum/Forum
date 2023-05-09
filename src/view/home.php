<?php 
    function view_home() {
        ob_start();
        $title = "Page principale"
?>

<div class=" w-1/2 fixed">
    <a class="btn absolute right-0" href="/index.php?action=newpost">Nouveau post</a>
</div>

<?php

    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_home()
    }

?>