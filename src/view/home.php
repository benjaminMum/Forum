<?php 
    function view_home($posts=null) {
        ob_start();
        $title = "Page principale"
?>

<?php if($_SESSION != NULL) {?>
<div class="grid grid-cols-12 grid-flow-row gap-y-7">
    <a class="btn col-span-1 col-start-10" href="/index.php?action=newpost">Nouveau post</a>
    <?php foreach($posts as $post) { ?>
        <div class="grid grid-col-12 col-span-10 border-solid border-2 border-sky-100 bg-zinc-200 relative h-48">
            <div class="col-span-2 row-span-5 absolute left-5 top-5 h-32 w-32">
                <img class="object-contain" src="./view/content/posts_img/35f4af5174.png">
            </div>
            <div class="col-span-5 col-start-2">
            <p><?= $post['title']?></p>
            </div>
            
        </div>
    <?php } ?>

</div>



<?php }?>

<?php

    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_home()
    }

?>