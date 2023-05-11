<?php 
    function view_newpost($err=null, $categories) {
        ob_start();
        $title = "Nouveau post";

?>

<script>



</script>

<?php if($_SESSION != NULL) {?>

<div class="w-1/2 mt-10">
    <h1 class="text-3xl text-center text-black">Nouveau post</h1>
    <?php if($err != null) { ?>
        <div class="alert alert-error shadow-lg mt-5">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span><?= $err ?></span>
            </div>
        </div>
    <?php } ?> 
    <div class="divider before:bg-primary after:bg-primary"></div>
    <form action="/index.php?action=newpost" method="POST" enctype="multipart/form-data">
        <!-- title -->
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">Titre</p>
            <textarea name="formNewpostTitle" class="textarea"></textarea>
        </div>
        <!-- category select -->
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">Catégorie</p>
            <div class="col-span-1">
                <select name="formNewpostCategory" class="select select-bordered w-full max-w-xs">
                    <option disabled selected>Catégorie</option>
                    <?php foreach($categories as $category) {?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <!-- divider 2 -->
        <div class="divider before:bg-sky-300 after:bg-sky-300 mt-20 text-lg text-black ">Médias</div>
        <!-- File/link -->        
        <div class="flex flex-col w-full lg:flex-row mt-10">
            <div class="grid flex-grow h-32">
                <div class="mb-10">
                    <p class="text-lg text-black">Fichier</p>
                    <input name="formNewpostFile" type="file" accept=".png,.jpg,.jpeg" class="file-input file-input-sm w-full mt-2" />
                </div>
            </div> 
            <div class="divider lg:divider-horizontal before:bg-cyan-300 after:bg-cyan-300">Ou</div> 
            <div class="grid flex-grow h-32">
            <div>
                <p class="text-lg text-black">Vidéo</p>
                <label class="input-group mt-2">
                    <span>Lien</span>
                    <input name="formNewpostLink" type="text" class="input input-sm input-bordered w-full" />
                </label>
            </div>
            </div>
        </div>
        <!-- Submit button -->
        <div class="grid form-control grid-cols-8 mt-10 relative">
            <input class="btn btn-primary col-span-1 absolute right-0" type="submit"></button>
        </div>
    </form>
</div>

<?php } else { // you are not connected... ?>


<?php } ?>


<?php
    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_newpost()
    }

?>