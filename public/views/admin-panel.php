<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="public/css/style.css">
        <link rel="stylesheet" href="public/css/admin-panel/admin-panel-style.css">
        <link rel="stylesheet" href="public/css/admin-panel/admin-panel-mobile-style.css" media="(max-width:912px)">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Graduate">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        
        <script src="public/scripts/dialog.js" defer></script>
        <script src="public/scripts/admin-actions.js" defer></script>
        <title>Admin panel</title>
    </head>

    <body>
        <div class="container">
            <div class="box">
                <div class="table-box">
                    <div class="table-title">
                        Users
                    </div>
                    <div class="user-table">
                        <div class="records">
                            <?php foreach($users as $user): ?>
                                <div class="row">
                                        <div class="user" data-id="<?=$user->getId()?>">
                                            <?= $user->getLogin();?>
                                        </div>
                                        <div class="user-actions">
                                            <button class="history">
                                                <img class="icon" src="public/img/history-icon.svg" alt="history">
                                            </button>
                                            <button class="deletion">
                                                <img class="icon" src="public/img/delete-icon.svg" alt="delete">
                                            </button>
                                        </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="actions">
                        <button>
                            <a href="login">
                                <img class="icon" src="public/img/logout-icon.svg" alt="logout">
                            </a>
                        </button>
                        <button>
                            <a href="dashboard">
                                <img class="icon" src="public/img/dashboard-icon.svg" alt="dashboard">
                            </a>
                        </button>
                    </div>
                </div>
            </div>    
        </div>
        <dialog id="alert-dialog">
           
        </dialog>
    </body>
</html>