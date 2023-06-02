<?php
function renderGabarit($title = null, $content = null)
{
?>
    <!DOCTYPE html>
    <html lang="fr" class="h-100">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            
            <link href="./view/css/output.css" rel="stylesheet">
            <title>
                <?= $title ?>
            </title>

        </head>

        <body class="bg-cyan-50 min-h-screen">
            <!-- navbar -->
            <div class="h-11">
                <div class="navbar bg-base-100 w-screen static object-right h-1/6">
                    <a class="btn btn-ghost normal-case text-xl static" href="/index.php?action=home">Home</a>
                    <!-- account buttons -->
                    <div class="static justify-end w-full">
                        <?php if($_SESSION['admin'] == true) {?>
                            <a class="btn btn-ghost normal-case text-xl relative right-5" href="/index.php?action=addCategory">Ajouter un thème</a> 
                            <a class="btn btn-ghost normal-case text-xl relative right-5" href="/index.php?action=showUsers">Utilisateurs</a> 
                            <a class="btn btn-ghost normal-case text-xl relative right-5" href="/index.php?action=showReports">Posts signalés</a> 
                        <?php } ?>
                        <?php if(empty($_SESSION)) { ?>
                            <a class="btn btn-ghost normal-case text-xl relative right-5" href="/index.php?action=login">Se connecter</a>
                            <a class="btn btn-ghost normal-case text-xl static" href="/index.php?action=register">S'enregistrer</a>
                        <?php } else { ?>
                            <a class="btn btn-ghost normal-case text-xl relative right-5" href="/index.php?action=disconnect">Déconnexion</a> 
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <div class="flex justify-center mt-10">
                <?php /** Content defined in views */?>
                <?= $content ?? "<h1>Contenu indisponible</h1>" ?>
            </div>


        </body>
    </html>
    <?php
    // This '}' Closes the function renderGabarit()
}
?>