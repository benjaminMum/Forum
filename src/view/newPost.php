<?php 
    function view_newpost($err=null) {
        ob_start();
        $title = "Nouveau post";

?>

<script>



</script>

<div class="w-1/2 mt-10 ">
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
    <form action="/index.php?action=newpost" method="POST">
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">Titre</p>
            <textarea name="formNewpostTitle" class="textarea"></textarea>
        </div>
        <!-- divider -->
        <div class="">
            <div class="divider before:bg-sky-300 after:bg-sky-300 mt-20 text-lg text-black w-1/2 content-center">Médias</div>
        </div>
        <!-- File input -->
        <div class="mb-10">
            <p class="text-lg text-black">Fichier</p>
            <input name="formNewpostFile" type="file" class="file-input file-input-sm w-1/2 mt-2" />
        </div>
        <!-- divider -->
        <div class="divider before:bg-cyan-300 after:bg-cyan-300">Ou</div>
        <!-- video link -->
        <div>
            <p class="text-lg text-black">Vidéo</p>
            <label class="input-group mt-2">
                <span>Lien</span>
                <input name="formNewpostLink" type="text" class="input input-sm input-bordered w-1/2" />
            </label>
        </div>

        <div class="grid form-control grid-cols-8 mt-10 relative">
            <input class="btn btn-primary col-span-1 absolute right-0" type="submit"></button>
        </div>
    </form>
</div>

        
<?php
    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_newpost()
    }

?>