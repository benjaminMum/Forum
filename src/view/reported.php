<?php 
    function view_reported($posts, $comments) {
        ob_start();
        $title = "Posts Signalés";

        require_once "model/userManager.php";
?>


<div class="grid grid-cols-12">
    <div class="divider col-span-7 col-start-2">Posts signalés</div> 
    <?php foreach($posts as $post) { ?>
        <?php if(str_contains($post['image_link'], "./view")) {?>
            <div class="divider col-span-5 col-start-3"></div> 
            <div class="grid grid-cols-12 col-span-5 col-start-3 grid-rows-6 gap-1 h-48">
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
                    <a class="btn col-span-1 col-start-12 mr-1 mt-3 btn-xs" href="/index.php?action=post&id=<?= $post['id'] ?>">Voir</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="divider col-span-5 col-start-3"></div> 
            <div class="grid grid-cols-12 col-span-5 col-start-3 grid-rows-6 gap-1 h-48">
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
                    <a class="btn col-span-1 col-start-12 mr-1 btn-xs" href="/index.php?action=post&id=<?= $post['id'] ?>">Voir</a>
                </div>
            </div>
        <?php } ?>
        <div class="col-span-3 col-start-10 flex flex-auto row-span-1 content-center">
            <a href="/index.php/action=allowPost&id=<?= $post['id'] ?>" class="bg-green-500 text-white btn mr-2">Restaurer</a>
            <a href="/index.php/action=banPost&id=<?= $post['id'] ?>" class="bg-red-500 text-white btn">Bannir</a>
        </div>
    <?php } ?>
    <div class="divider col-span-7 col-start-2">Commentaires signalés</div> 
    <?php foreach($comments as $comment) {?>
            <?php if(str_contains($comment['image_link'], "./view")) {?>
                <div class="grid grid-cols-12 col-span-5 col-start-3 grid-rows-6 gap-1 h-48 mt-5">
                    <div class="col-span-4 row-span-6 bg-cyan-50 rounded-md flex flex-col">
                        <img class="w-full object-contain min-h-0" src="<?= $comment['image_link']?>">
                    </div> 
                    <div class="grid grid-cols-3 col-span-8 row-span-1 mb-1 bg-slate-300 rounded-md">
                        <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($comment['user_id']) ?> </p>
                        <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $comment['date'] ?> </p>
                    </div>
                    <div class="grid grid-cols-12 grid-row-6 col-span-8 row-span-5 bg-slate-300 rounded-md">
                        <p class=" text-black col-span-12 row-span-4 ml-2 overflow-y-auto"><?= $comment['text'] ?></p>
                    </div>
                </div>
            <?php } else { ?>
                <div class="grid grid-cols-12 col-span-5 col-start-3 grid-rows-6 gap-1 h-48 mt-5">
                    <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                        <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($comment['user_id']) ?> </p>
                        
                        <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $comment['date'] ?></p>
                    </div>
                    <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                        <p class="text-left col-span-3 text-black ml-2 ">Lien vidéo : <a href="<?= $comment['image_link']?>" class="underline text-blue-700"><?= $comment['image_link'] ?> </a></p>
                    </div>
                    <div class="grid grid-cols-12 grid-row-6 col-span-12 row-span-4 bg-slate-300 rounded-md">
                        <p class=" text-black col-span-12 row-span-4 ml-2 overflow-y-auto"><?= $comment['text'] ?></p>
                    </div>
                </div>
            <?php } ?>
            <div class="col-span-3 col-start-10 flex flex-auto row-span-1 content-center">
                <a href="/index.php/action=allowComment&id=<?= $post['id'] ?>" class="bg-green-500 text-white btn mr-2">Restaurer</a>
                <a href="/index.php/action=banComment&id=<?= $post['id'] ?>" class="bg-red-500 text-white btn">Bannir</a>
            </div>
        <?php } ?>
</div>

<?php

    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_reported()
    }

?>