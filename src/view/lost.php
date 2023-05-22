<?php 
    function view_lost() {
        ob_start();
        $title = "404";

?>

<div class="hero h-max w-1/2 bg-base-200 mt-10">
  <div class="hero-content text-center">
    <div class="max-w-md">
      <h1 class="text-5xl font-bold">404</h1>
      <p class="py-6">Page ou post introuvable</p>
    </div>
  </div>
</div>

<?php
    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_lost()
    }

?>