<?php 
    function view_addCategory($categories, $err=null) {
        ob_start();
        $title = "Nouvelle catégorie";

?>



<div class="w-1/2 mt-10">
    <h1 class="text-3xl text-center text-black">Nouvelle catégorie</h1>
    <div class="divider hover:before:bg-red-500 hover:after:bg-red-500"></div>
    <?php if($err != null) { ?>
        <div class="alert alert-error shadow-lg mt-5">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span><?= $err ?></span>
            </div>
        </div>
    <?php } ?> 
    <form action="/index.php?action=addCategory" method="POST" enctype="multipart/form-data" class="mb-10">
        <!-- title -->
        <div class="grid grid-cols-2 grid-flow-row mt-5">
            <p class="col-span-1 text-lg text-black">Titre</p>
            <input name="formAddCategoryName" type="text" class="input"></input>
        </div>
        <!-- Submit button -->
        <div class="grid form-control grid-cols-8 mt-5 mb-5 relative">
            <input class="btn btn-primary col-span-1 absolute right-0" type="submit"></button>
        </div>
    </form>
    <div class="divider mt-5"></div>
    <!-- display all categories -->
    <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <table class="min-w-full text-left text-sm font-light">
            <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-4">ID</th>
                    <th scope="col" class="px-6 py-4">Nom</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $categorie) { ?>
                    <tr>
                            <td class="whitespace-nowrap px-6 py-4 font-medium"><?= $categorie['id'] ?></td>
                            <td class="whitespace-nowrap px-6 py-4"><?= $categorie['name'] ?></td>
                    </tr>
                <?php }?>
            </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>

</div>


<?php
    $content = ob_get_clean();
    require_once "view/gabarit.php";
    renderGabarit($title, $content);

    // Closes the function view_addCategory()
    }

?>