<?php 
    function view_closed() {
        ob_start();
        $title = "404";

?>

<div class="hero h-max w-1/2 bg-base-200 mt-10">
  <div class="hero-content text-center">
    <div class="max-w-md">
      <h1 class="text-5xl font-bold">Post archivé ou bloqué</h1>
      <p class="py-6">Ce post a été archivé ou bloqué par un administrateur</p>
    </div>
  </div>
</div>

<?php
    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_closed()
    }

?>