<?php 
    function view_home($posts=null) {
        ob_start();
        $title = "Page principale";

        require_once "model/userManager.php";
?>


<div class="grid grid-cols-12">
    <?php if($_SESSION != NULL) {?>
    <a class="btn col-start-10 mb-5" href="/index.php?action=newpost">Nouveau post</a>
    <?php }?>

    <?php foreach($posts as $post) { ?>
        <?php if(str_contains($post['image_link'], "./view")) {?>
            <div class="divider col-span-9 col-start-2"></div> 
            <div class="grid grid-cols-12 col-span-5 col-start-4 grid-rows-6 gap-1 h-48">
                <div class="col-span-4 row-span-6 bg-cyan-50 rounded-md flex flex-col">
                    <img class="w-full object-contain min-h-0" src="<?= $post['image_link']?>">
                </div> 
                <div class="grid grid-cols-3 col-span-8 row-span-1 mb-1 bg-slate-300 rounded-md">
                    <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($post['user_id']) ?> </p>
                    <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $post['date'] ?> </p>
                </div>
                <div class="grid grid-cols-12 grid-row-6 col-span-8 row-span-5 bg-slate-300 rounded-md">
                    <p class="text-lg text-black col-span-12 row-span-1 ml-2 mt-2">Titre :</p>
                    <p class=" text-black col-span-12 row-span-4 ml-2"><?= $post['title'] ?></p>
                    <a class="btn col-span-2 col-start-11 mr-2 btn-sm" href="/index.php?action=post&id=<?= $post['id'] ?>">Voir</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="divider col-span-9 col-start-2"></div> 
            <div class="grid grid-cols-12 col-span-5 col-start-4 grid-rows-6 gap-1 h-48">
                <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                    <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($post['user_id']) ?> </p>
                    <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $post['date'] ?></p>
                </div>
                <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                    <p class="text-left col-span-3 text-black ml-2 ">Lien vidéo : <a href="<?= $post['image_link']?>" class="underline text-blue-700"><?= $post['image_link'] ?> </a></p>
                </div>
                <div class="grid grid-cols-12 grid-row-6 col-span-12 row-span-4 bg-slate-300 rounded-md">
                    <p class="text-lg text-black col-span-12 row-span-1 ml-2 mt-2">Titre :</p>
                    <p class=" text-black col-span-12 row-span-4 ml-2"><?= $post['title'] ?></p>
                    <a class="btn col-span-2 col-start-11 mr-2 btn-sm" href="/index.php?action=post&id=<?= $post['id'] ?>">Voir</a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

</div>





<?php

    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_home()
    }

?>