<?php 
    function view_post($post, $comments) {
        ob_start();
        $title = "Post";

?>

<div class="grid grid-cols-12">
    <!-- Post -->
    <?php if(str_contains($post['image_link'], "./view")) {?>
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
                <p class=" text-black col-span-12 row-span-4 ml-2 overflow-y-auto"><?= $post['title'] ?></p>
                <a class="btn col-span-3 col-start-10 mr-2 btn-sm" href="/index.php?action=commentPost&id=<?= $post['id'] ?>">Commenter</a>
            </div>
        </div>
        <div class="divider col-span-9 col-start-2 mt-3 mb-3"></div>
    <?php } else { ?>
        
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
                <p class=" text-black col-span-12 row-span-4 ml-2 overflow-y-auto"><?= $post['title'] ?></p>
                <a class="btn col-span-2 col-start-11 mr-2 btn-sm" href="/index.php?action=commentPost&id=<?= $post['id'] ?>">Commenter</a>
            </div>
        </div>
        <div class="divider col-span-9 col-start-2 mt-3 mb-3"></div>
    <?php } ?>

    <div class="divider"></div>
    <!-- Com level 1-->
    <?php foreach($comments as $comment1) {?>
        <?php if($comment1['comment_id'] == null) {?>
            <?php if(str_contains($comment1['image_link'], "./view")) {?>
                <div class="grid grid-cols-12 col-span-5 col-start-4 grid-rows-6 gap-1 h-48 mt-5">
                    <div class="col-span-4 row-span-6 bg-cyan-50 rounded-md flex flex-col">
                        <img class="w-full object-contain min-h-0" src="<?= $comment1['image_link']?>">
                    </div> 
                    <div class="grid grid-cols-3 col-span-8 row-span-1 mb-1 bg-slate-300 rounded-md">
                        <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($comment1['user_id']) ?> </p>
                        <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $comment1['date'] ?> </p>
                    </div>
                    <div class="grid grid-cols-12 grid-row-6 col-span-8 row-span-5 bg-slate-300 rounded-md">
                        <p class=" text-black col-span-12 row-span-4 ml-2 overflow-y-auto"><?= $comment1['text'] ?></p>
                        <a class="btn col-span-3 col-start-10 mr-2 btn-sm" href="/index.php?action=commentComment&id=<?= $comment1['id']?>">Commenter</a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="grid grid-cols-12 col-span-5 col-start-4 grid-rows-6 gap-1 h-48 mt-5">
                    <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                        <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($comment1['user_id']) ?> </p>
                        <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $comment1['date'] ?></p>
                    </div>
                    <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                        <p class="text-left col-span-3 text-black ml-2 ">Lien vidéo : <a href="<?= $comment1['image_link']?>" class="underline text-blue-700"><?= $comment1['image_link'] ?> </a></p>
                    </div>
                    <div class="grid grid-cols-12 grid-row-6 col-span-12 row-span-4 bg-slate-300 rounded-md">
                        <p class=" text-black col-span-12 row-span-4 ml-2 overflow-y-auto"><?= $comment1['text'] ?></p>
                        <a class="btn col-span-2 col-start-11 mr-2 btn-sm" href="/index.php?action=commentComment&id=<?= $comment1['id']?>">Commenter</a>
                    </div>
                </div>
            <?php } ?>
            <!-- Com level 2-->
            <?php foreach($comments as $comment2) {?>
                <?php if($comment2['comment_id'] == $comment1['id']) {?>
                    <?php if(str_contains($comment2['image_link'], "./view")) {?>
                        <div class="grid grid-cols-12 col-span-5 col-start-5 grid-rows-6 gap-1 h-48 mt-5">
                            <div class="col-span-4 row-span-6 bg-cyan-50 rounded-md flex flex-col">
                                <img class="w-full object-contain min-h-0" src="<?= $comment2['image_link']?>">
                            </div> 
                            <div class="grid grid-cols-3 col-span-8 row-span-1 mb-1 bg-slate-300 rounded-md">
                                <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($comment2['user_id']) ?> </p>
                                <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $comment2['date'] ?> </p>
                            </div>
                            <div class="grid grid-cols-12 grid-row-6 col-span-8 row-span-5 bg-slate-300 rounded-md">
                                <p class=" text-black col-span-12 row-span-4 ml-2 overflow-y-auto"><?= $comment2['text'] ?></p>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="grid grid-cols-12 col-span-5 col-start-5 grid-rows-6 gap-1 h-48 mt-5">
                            <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                                <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($comment2['user_id']) ?> </p>
                                <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $comment2['date'] ?></p>
                            </div>
                            <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                                <p class="text-left col-span-3 text-black ml-2 ">Lien vidéo : <a href="<?= $comment2['image_link']?>" class="underline text-blue-700"><?= $comment2['image_link'] ?> </a></p>
                            </div>
                            <div class="grid grid-cols-12 grid-row-6 col-span-12 row-span-4 bg-slate-300 rounded-md">
                                <p class=" text-black col-span-12 row-span-4 ml-2 overflow-y-auto"><?= $comment2['text'] ?></p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>        
        <?php } ?>
    <?php } ?>

</div>


<?php
    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_post()
    }

?>