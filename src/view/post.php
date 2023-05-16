<?php 
    function view_post($post) {
        ob_start();
        $title = "Post";

?>

<div class="w-1/2 mt-10">

    <?php if(str_contains($post['image_link'], "./view")) {?>
        <div class="divider col-span-9 col-start-2"></div> 
        <div class="grid grid-cols-12 col-span-9 col-start-2 grid-rows-6 gap-1 h-48">
            <div class="col-span-2 row-span-6 bg-cyan-50">
                <img class="object-scale-down" src="<?= $post['image_link']?>">
            </div> 
            <div class="grid grid-cols-3 col-span-10 row-span-1 mb-1 bg-slate-300">
                <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($post['user_id']) ?> </p>
                <p class="text-center col-span-1 text-black ml-2">le <?= $post['date'] ?> </p>
                
            </div>
            <div class="grid grid-cols-12 grid-row-6 col-span-10 row-span-5 bg-slate-300">
                <p class="text-lg text-black col-span-12 row-span-1 ml-2 mt-2">Titre :</p>
                <p class=" text-black col-span-12 row-span-4 ml-2">text-lg text-black col-span-12</p>
                <button class="btn col-span-1 col-start-12 mr-2 btn-sm" >test</button>
            </div>
        </div>
    <?php } else { ?>
        <div class="divider col-span-9 col-start-2"></div> 
        <div class="grid grid-cols-12 col-span-11 col-start-2 grid-rows-6 gap-1 h-48">
            <div class="grid grid-cols-3 col-span-10 row-span-1 mb-1 bg-slate-300">
                <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($post['user_id']) ?> </p>
                <p class="text-center col-span-1 text-black ml-2">le <?= $post['date'] ?></p>
            </div>
            <div class="grid grid-cols-3 col-span-10 row-span-1 mb-1 bg-slate-300">
                <p class="text-left col-span-1 text-black ml-2 ">Lien vidéo : <a href="<?= $post['image_link']?>" class="underline text-blue-700"><?= $post['image_link'] ?> </a></p>
            </div>
            <div class="grid grid-cols-12 grid-row-6 col-span-10 row-span-4 bg-slate-300">
                <p class="text-lg text-black col-span-12 row-span-1 ml-2 mt-2">Titre :</p>
                <p class=" text-black col-span-12 row-span-4 ml-2">text-lg text-black col-span-12</p>
                <button class="btn col-span-1 col-start-12 mr-2 btn-sm" >Voir</button>
            </div>
        </div>
    <?php } ?>

</div>




<?php
    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_post()
    }

?>