<?php 
    function view_register($err=null) {
        ob_start();
        $title = "S'enregistrer";

        if($_SESSION['newAccount'] != true) {
?>

<div class="w-1/2 mt-10 ">
    <h1 class="text-3xl text-center text-black">S'enregistrer</h1>
    <?php if($err != null) { ?>
        <div class="alert alert-error shadow-lg mt-5">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span><?= $err ?></span>
            </div>
        </div>
    <?php } ?>
    <div class="divider before:bg-primary after:bg-primary"></div>
    <form action="/index.php?action=register" method="POST">
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">E-Mail</p>
            <input name="formRegisterEmail" placeholder="example@xyz.com" type="email" class="input input-bordered col-span-1" />
        </div>
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">Nom d'utilisateur</p>
            <input name="formRegisterUsername" placeholder="Nom d'utilisateur" type="text" class="input input-bordered col-span-1" />
        </div>
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">Mot de passe</p>
            <input name="formRegisterPassword" type="password" class="input input-bordered col-span-1" />
        </div>
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">Confirmation mot de passe</p>
            <input name="formRegisterConfirmPassword" type="password" class="input input-bordered col-span-1" />
        </div>
        <div class="grid form-control grid-cols-8 mt-10 relative">
            <input class="btn btn-primary col-span-1 absolute right-0" type="submit"></button>
        </div>
    </form>
</div>

<?php } else { ?>
<div class="w-1/2 mt-10 ">
    <h1 class="text-3xl text-center text-black">Vérifiez votre boîte mail !</h1>
    <p class="text-center text-black mt-5">Un mail vous a été envoyé afin de finaliser l'inscription.</p>
</div>
        
<?php
    }
    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_register()
    }

?>