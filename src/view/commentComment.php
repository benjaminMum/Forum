<?php 
    function view_commentComment($post, $comment, $err=null) {
        ob_start();
        $title = "Commenter un Commentaire";

?>

<div class="w-1/2 mt-10">
    <?php if($_SESSION != NULL) {?>
        <!-- Post  -->
        <?php if(str_contains($post['image_link'], "./view")) {?>
            <div class="divider col-span-9 col-start-2">Post</div> 
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
                    <button class="btn col-span-2 col-start-11 mr-2 btn-sm" >Voir</button>
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
                    <button class="btn col-span-2 col-start-11 mr-2 btn-sm" >Voir</button>
                </div>
            </div>
        <?php } ?>
        <!-- Comment that will be commented  -->
        <div class="divider col-span-9 col-start-2"> Commentaire</div> 
        <?php if(str_contains($comment['image_link'], "./view")) {?>
            <div class="grid grid-cols-12 col-span-5 col-start-5 grid-rows-6 gap-1 h-48">
                <div class="col-span-4 row-span-6 bg-cyan-50 rounded-md flex flex-col">
                    <img class="w-full object-contain min-h-0" src="<?= $comment['image_link']?>">
                </div> 
                <div class="grid grid-cols-3 col-span-8 row-span-1 mb-1 bg-slate-300 rounded-md">
                    <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($comment['user_id']) ?> </p>
                    <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $comment['date'] ?> </p>
                </div>
                <div class="grid grid-cols-12 grid-row-6 col-span-8 row-span-5 bg-slate-300 rounded-md">
                    <p class="text-lg text-black col-span-12 row-span-1 ml-2 mt-2">Titre :</p>
                    <p class=" text-black col-span-12 row-span-4 ml-2"><?= $comment['text'] ?></p>
                </div>
            </div>
        <?php } else { ?>
            <div class="grid grid-cols-12 col-span-5 col-start-5 grid-rows-6 gap-1 h-48">
                <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                    <p class="text-left col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($comment['user_id']) ?> </p>
                    <p class="text-center col-span-2 col-start-2 text-black ml-2">le <?= $comment['date'] ?></p>
                </div>
                <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                    <p class="text-left col-span-3 text-black ml-2 ">Lien vidéo : <a href="<?= $comment['image_link']?>" class="underline text-blue-700"><?= $comment['image_link'] ?> </a></p>
                </div>
                <div class="grid grid-cols-12 grid-row-6 col-span-12 row-span-4 bg-slate-300 rounded-md">
                    <p class="text-lg text-black col-span-12 row-span-1 ml-2 mt-2">Titre :</p>
                    <p class=" text-black col-span-12 row-span-4 ml-2"><?= $comment['text'] ?></p>
                </div>
            </div>
        <?php } ?>

    <div class="divider"></div>

    <h1 class="text-3xl text-center text-black">Répondre</h1>
    <?php if($err != null) { ?>
        <div class="alert alert-error shadow-lg mt-5">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span><?= $err ?></span>
            </div>
        </div>
    <?php } ?> 
    <div class="divider before:bg-primary after:bg-primary"></div>
    <form action="/index.php?action=commentComment&id=<?= $comment['id'] ?>" method="POST" enctype="multipart/form-data">
        <!-- Text -->
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">Commentaire</p>
            <textarea name="formCommentCommentComment" class="textarea"></textarea>
        </div>
        <!-- divider 2 -->
        <div class="divider before:bg-sky-300 after:bg-sky-300 mt-20 text-lg text-black ">Médias</div>
        <!-- File/link -->        
        <div class="flex flex-col w-full lg:flex-row mt-10">
            <div class="grid flex-grow h-32">
                <div class="mb-10">
                    <p class="text-lg text-black">Fichier</p>
                    <input name="formCommentCommentFile" type="file" accept=".png,.jpg,.jpeg" class="file-input file-input-sm w-full mt-2" />
                </div>
            </div> 
            <div class="divider lg:divider-horizontal before:bg-cyan-300 after:bg-cyan-300">Ou</div> 
            <div class="grid flex-grow h-32">
                <div>
                    <p class="text-lg text-black">Vidéo</p>
                    <label class="input-group mt-2">
                        <span>Lien</span>
                        <input name="formCommentCommentLink" type="text" class="input input-sm input-bordered w-full" />
                    </label>
                </div>
            </div>
        </div>
        <!-- Submit button -->
        <div class="grid form-control grid-cols-8 mt-10">
            <input class="btn btn-primary col-span-1 col-start-8" type="submit"></button>
        </div>
    </form>

<?php }  else { // TODO : you are not connected?>
    <div class="hero w-full content-center text-center mt-52">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold text-gray-600">Vous n'êtes pas connecté</h1>
                <p class="py-6 text-gray-900">Veuillez vous connecter pour pouvoir commenter un commentaire</p>
            </div>
        </div>
    </div>
<?php }?>
</div>




<?php
    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_commentPost()
    }

?>