<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="public/css/style.css">
        <link rel="stylesheet" href="public/css/setting-style/settings-style.css">
        <link rel="stylesheet" href="public/css/setting-style/settings-mobile-style.css" media="(max-width:912px)">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Graduate">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        
        <title>Settings</title>
    </head>

    <body>
        <div class="container">
            <div class="box">
                <div class="table-box">
                    <div class="table-title">
                        Setting
                    </div>
                    <div class="settings-table">
                        <div class="records">
                            <div class="setting">
                                <div class="label">
                                    email
                                </div>
                                <input type="email" value="example@mail.com" readonly/>
                                <button class="left-offset-button">
                                    change email
                                </button>
                            </div>
                            <div class="setting">
                                <div class="label">
                                    password
                                </div>
                                <button>
                                    change password
                                </button>
                            </div>
                            <div class="setting">
                                <div class="label">
                                    language
                                </div>
                                <select>
                                    <option class="lang">
                                        <div>EN</div>
                                    </option>
                                    <option class="lang">
                                        <div>PL</div>
                                    </option>
                                </select>
                                <button class="left-offset-button">
                                    <img class="icon" src="public/img/save-icon.svg">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="actions">
                        <a href="dashboard">
                            <button>
                                <img class="icon" src="public/img/back-icon.svg">
                            </button>
                        </a>
                    </div>
                </div>
            </div>    
        </div>
    </body>
</html>