<?php 
    function view_login($err=null) {
        ob_start();
        $title = "Se connecter";

?>

<div class="w-1/2 mt-10 ">
    <h1 class="text-3xl text-center text-black">Se connecter</h1>
    <div class="divider before:bg-primary after:bg-primary"></div>
    <form action="/index.php?action=register" method="POST">
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">E-Mail</p>
            <input name="formLoginEmail" type="text" class="input input-bordered col-span-1" />
        </div>
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">Mot de passe</p>
            <input name="formLoginPassword" type="password" class="input input-bordered col-span-1" />
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

    // Closes the function view_login()
    }

?>