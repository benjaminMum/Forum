<?php 
    function view_users($users) {
        ob_start();
        $title = "Utilisateurs";

?>



<div class="w-1/2 mt-10">
    <h1 class="text-3xl text-center text-black">Utilisateurs</h1>
    
    <!-- display all categories -->
    <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <table class="min-w-full text-left text-sm font-light">
            <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-4">ID</th>
                    <th scope="col" class="px-6 py-4">E-Mail</th>
                    <th scope="col" class="px-6 py-4">Nom d'utilisateur</th>
                    <th scope="col" class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) { ?>
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 font-medium"><?= $user['id'] ?></td>
                        <td class="whitespace-nowrap px-6 py-4"><?= $user['email'] ?></td>
                        <td class="whitespace-nowrap px-6 py-4"><?= $user['username'] ?></td>
                        <td class="whitespace-nowrap px-6 py-4"><a href="/index.php?action=blockUser&id=<?= $user['id']?>" class="btn btn-error">Bloquer</a></td>
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

    // Closes the function view_users()
    }

?>