<?php 
    function view_home($posts=null, $categories) {
        ob_start();
        $title = "Page principale";

        require_once "model/userManager.php";
?>


<div class="grid grid-cols-12 w-1/2 mt-10">

    <!-- Page selection -->
    <div class="flex flex-nowrap col-span-3 gap-2 col-start-2">
        <div class="join">
            <button class="join-item btn mr-2" onclick="window.location.href='/index.php?action=home&page=1';">1</button>
            <?php if($_GET['page'] != null) {?>
            <?php  for($i = $_GET['page']; $i < $_GET['page'] + 3; $i++)  { ?>
                    <button class="join-item btn" onclick="window.location.href='/index.php?action=home&page=<?= $i ?>';"><?= $i ?></button>
                <?php } ?>
            <?php } else { ?>
                <button class="join-item btn" onclick="window.location.href='/index.php?action=home&page=2';">2</button>
                <button class="join-item btn" onclick="window.location.href='/index.php?action=home&page=3';">3</button>
                <button class="join-item btn" onclick="window.location.href='/index.php?action=home&page=4';">4</button>
            <?php } ?>
        </div>

        <div class="divider divider-vertical before:bg-red-500"></div>
    </div>

    

    <!-- Category selection -->
    <form action="/index.php?action=home" method="POST" class="flex flex-nowrap col-span-2 gap-2 col-start-6">
        <p class="text-lg text-black mr-5 mt-2">Catégorie</p>
        <select name="categoryChoice" class="select select-bordered w-full max-w-xs">
            <option disabled selected>Catégorie</option>
            <?php foreach($categories as $category) {?>
            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php } ?>
        </select>
        <input type="submit" class="btn btn-sm mt-2" value="Filtrer">
    </form>

    <?php if($_SESSION != NULL) {?>
    <a class="btn col-start-12 mb-5" href="/index.php?action=newpost">Nouveau post</a>
    <?php }?>

    <?php foreach($posts as $post) { ?>
        <?php if(str_contains($post['image_link'], "./view")) {?>
            <div class="divider col-span-9 col-start-2"></div> 
            <div class="grid grid-cols-12 col-span-8 col-start-3 grid-rows-6 gap-1 h-48">
                <div class="col-span-4 row-span-6 bg-cyan-50 rounded-md flex flex-col">
                    <img class="w-full object-contain min-h-0" src="<?= $post['image_link']?>">
                </div> 
                <div class="grid grid-cols-3 col-span-8 row-span-1 mb-1 bg-slate-300 rounded-md">
                    <p class="text-left text-sm col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($post['user_id']) ?> </p>
                    <p class="text-center text-sm col-span-2 col-start-2 text-black ml-2">le <?= $post['date'] ?> </p>
                </div>
                <div class="grid grid-cols-12 grid-row-6 col-span-8 row-span-5 bg-slate-300 rounded-md">
                    <p class="text-lg text-black col-span-12 row-span-1 ml-2 mt-2">Titre :</p>
                    <p class=" text-black col-span-12 row-span-4 ml-2"><?= $post['title'] ?></p>
                </div>
                <div class="flex flex-nowrap col-span-12 row-span-1 justify-end mr-1 gap-1">
                    <?php if($_SESSION['admin'] == true) { ?>
                        <a class="btn btn-secondary btn-xs" href="/index.php?action=archivePost&id=<?= $post['id'] ?>">Archiver</a>
                        <a class="btn btn-xs" href="/index.php?action=blockPost&id=<?= $post['id'] ?>">Bloquer</a>
                    <?php } ?>
                    <a class="btn btn-error btn-xs" href="/index.php?action=reportTempo&postid=<?= $post['id'] ?>">Signaler</a>
                    <a class="btn bg-blue-400 btn-xs text-black" href="/index.php?action=post&id=<?= $post['id'] ?>">Voir</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="divider col-span-9 col-start-2"></div> 
            <div class="grid grid-cols-12 col-span-8 col-start-3 grid-rows-6 gap-1 h-48">
                <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                    <p class="text-left text-sm col-span-1 text-black ml-2">Utilisateur : <?= getUsernameById($post['user_id']) ?> </p>
                    <p class="text-center text-sm col-span-2 col-start-2 text-black ml-2">le <?= $post['date'] ?></p>
                </div>
                <div class="grid grid-cols-3 col-span-12 row-span-1 mb-1 bg-slate-300 rounded-md">
                    <p class="text-left col-span-3 text-black ml-2 ">Lien vidéo : <a href="<?= $post['image_link']?>" class="underline text-blue-700"><?= $post['image_link'] ?> </a></p>
                </div>
                <div class="grid grid-cols-12 grid-row-6 col-span-12 row-span-4 bg-slate-300 rounded-md">
                    <p class="text-lg text-black col-span-12 row-span-1 ml-2 mt-2">Titre :</p>
                    <p class=" text-black col-span-12 row-span-4 ml-2"><?= $post['title'] ?></p>
                </div>
                <div class="flex flex-nowrap col-span-12 row-span-1 justify-end mr-1 gap-1">
                    <?php if($_SESSION['admin'] == true) { ?>
                        <a class="btn btn-secondary btn-xs" href="/index.php?action=archivePost&id=<?= $post['id'] ?>">Archiver</a>
                        <a class="btn btn-xs" href="/index.php?action=blockPost&id=<?= $post['id'] ?>">Bloquer</a>
                    <?php } ?>
                    <a class="btn btn-error btn-xs" href="/index.php?action=reportTempo&postid=<?= $post['id'] ?>">Signaler</a>
                    <a class="btn bg-blue-400 btn-xs text-black" href="/index.php?action=post&id=<?= $post['id'] ?>">Voir</a>
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