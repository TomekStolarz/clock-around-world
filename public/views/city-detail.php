<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="public/css/style.css">
        <link rel="stylesheet" href="public/css/city-detail-style/city-detail-style.css">
        <link rel="stylesheet" href="public/css/city-detail-style/city-detail-mobile-style.css" media="(max-width:912px)">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Graduate">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        
        <title>City Detail {{city.name}}</title>
    </head>

    <body>
        <div class="container">
            <div class="box">
                <div class="detail-table-box">
                    <div class="table-title">
                        city details
                    </div>
                    <div class="detail-table">
                        <div class="records">
                            <div class="detail-group">
                                <div class="label">
                                    city name:
                                </div>
                                <div class="col-value">
                                    cracow
                                </div>
                            </div>
                            <div class="detail-group">
                                <div class="label">
                                    country:
                                </div>
                                <div class="col-value">
                                    poland
                                </div>
                            </div>
                            <div class="detail-group">
                                <div class="label">
                                    latitude:
                                </div>
                                <div class="col-value">
                                    50° 03' 41.15
                                </div>
                            </div>
                            <div class="detail-group">
                                <div class="label">
                                    longitude:
                                </div>
                                <div class="col-value">
                                    19° 56' 11.69
                                </div>
                            </div>
                            <div class="detail-group">
                                <div class="label">
                                    timezone:
                                </div>
                                <div class="col-value">
                                    GMT +2
                                </div>
                            </div>
                            <div class="detail-group">
                                <div class="label">
                                    time:
                                </div>
                                <div class="col-value">
                                    10:00
                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <button type="submit">Remove city from favourites</button>
                            <button type="submit">Add city to favourites</button>
                        </div>
                    </div>
                    <div class="actions back">
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