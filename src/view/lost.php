<?php 
    function view_lost($customText=null, $customTitle=null) {
        ob_start();
        $title = "404";

?>

<div class="hero h-max w-1/2 bg-base-200 mt-10">
  <div class="hero-content text-center">
    <div class="max-w-md">

      <?php if($customTitle != null) {?>
        <h1 class="text-5xl font-bold"><?= $customTitle?></h1>
      <?php } else {?>
        <h1 class="text-5xl font-bold">404</h1>
      <?php } ?>

      <?php if($customText != null) {?>
        <p class="py-6"><?= $customText?></p>
      <?php } else {?>
        <p class="py-6">Page ou post introuvable</p>
      <?php } ?>
      
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