<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="public/css/style.css">
        <link rel="stylesheet" href="public/css/dashboard-style/dashboard-style.css">
        <link rel="stylesheet" href="public/css/dashboard-style/dashboard-mobile-style.css" media="(max-width:912px)">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Graduate">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kelly+Slab">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        
        <script src="public/scripts/clock.js"></script>
        <script src="public/scripts/dashboard-clock.js" defer></script>
        <script>
            const cityTimezones = [];                  
        </script>
        <title>Dashboard</title>
    </head>

    <body>
        <div class="container">
            <div class="box">
                <div class="clock-box">
                    <div class="clock-title">
                        Time at
                    </div>
                    <div class="clock">
                        <div class="tile-group">
                            <div class="number-tile" data-value="0">0</div>
                            <div class="number-tile" data-value="0">0</div>
                        </div>
                        <div class="tile-group">
                            <div class="number-tile" data-value="0">0</div>
                            <div class="number-tile" data-value="0">0</div>
                        </div>
                        <div class="tile-group">
                            <div class="number-tile" data-value="0">0</div>
                            <div class="number-tile" data-value="0">0</div>
                        </div>
                    </div>
                </div>
                <div class="table-box">
                    <div class="table-title">
                        followed cities
                    </div>
                    <div class="followed-table">
                        <div class="row title-row">
                            <div class="col">
                                city
                            </div>
                            <div class="col">
                                timezone
                            </div>
                            <div class="col">
                                time
                            </div>
                        </div>
                        <div class="records">
                            <?php foreach($followedCities as $city): ?>
                            <a class="row" href="public/citydetail/<?= $city->getId()?>">
                                <div class="col">
                                    <?= $city->getCity()?>
                                </div>
                                <div class="col">
                                    <?= $city->getTimezone()?>
                                    <script>
                                        cityTimezones.push(JSON.parse(`<?= json_encode($city->jsonSerialize());?>`));
                                    </script>
                                </div>
                                <div class="col city-time">
                                    
                                </div>
                            </a>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="button-box">
                        <div class="actions">
                            <a href="settings">
                                <button>
                                    <img class="icon" src="public/img/setting-icon.svg">
                                </button>
                            </a>
                            <a href="logout">
                                <button>
                                    <img class="icon" src="public/img/logout-icon.svg">
                                </button>
                            </a>
                        </div>
                        <a href="search">
                            <button>Find city 
                                    <span class="material-symbols-outlined">
                                        search
                                    </span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>    
        </div>
    </body>
</html>