<!DOCTYPE html>
<html lang="de">
    
<!-- Site: 'Menü' -->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Steuerung Fungarium</title>

        <!-- homescreen icon -->
        <link rel="icon" type="image/ico" href="favicon.ico/mushrooms.ico">
        
        <!-- css stylesheets --> 
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/tooplate.css">
        <link rel="stylesheet" href="css/time.css">
        
        <!-- input value out of range -> red border -->
        <style>
            input:out-of-range {
                border:2px solid red;
            }
        </style>
    </head>

    <body id="reportsPage">
        <div class="" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- navigationbar with dropdown menu -->
                        <nav class="navbar navbar-expand-xl navbar-light bg-light">
                            <a class="navbar-brand" href="#">
                                <!-- navigationbar icon -->
                                <img src="favicon.ico/mushrooms_30.ico" >
                                <h1 class="tm-site-title mb-0">Fungarium</h1>
                            </a>
                            <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mx-auto">
                                    
                                    <!-- pages in navigationbar -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php">Menü</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="temperature.php">Temperatur</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="feuchtigkeit.php">Feuchtigkeit</a>
                                    </li>                               
                                    <li class="nav-item">
                                        <a class="nav-link" href="protokoll.php">Protokoll</a>
                                    </li>     
                                    <li class="nav-item">
                                        <a class="nav-link" href="manuell.php">Manuell</a>
                                    </li>         
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                
                <!-- 1. white block, includes 'Lichteinstellungen': 'Lichtstart' & 'Lichtende'-->
                 <div class="row tm-content-row tm-mt-big">
                    <div class="tm-col tm-col-big">
                        <div class="bg-white tm-block h-100">
                            <h2 class="tm-block-title">Licht Einstellungen</h2>
                            <form method="get" action="" id="contactform">
                                <label for="appt1" method>Aktueller Lichtstart:</label>
                                <input type="time" id="lichtstart" name="lichtstart" 
                                    min="09:00" max="18:00" value= <?php echo einstellungen('Lichtstart');?> required>
                                <input type="submit" class="submit">
                                <label for="appt">Aktuelles Lichtende:</label>
                                <input type="time" id="lichtende" name="lichtende" 
                                    min="09:00" max="18:00" value= <?php echo einstellungen('Lichtende');?> required>
                                <input type="submit" class="submit">
                            </form>
                                <div class="result">
                            </div>
                        </div>
                    </div>
                    
                    <!-- 2. white block, includes 'Temperatureinstellungen': 'Mindesttemperatur' & 'Höchsttemperatur'-->
                    <div class="tm-col tm-col-big">
                        <div class="bg-white tm-block h-100">
                            <h2 class="tm-block-title">Temperatur Einstellungen</h2>
                            <form method="get" action="" id="contactform">
                                <label for="mindesttemp">Mindesttemperatur</label>
                                    <input id="mindesttemp" name="mindesttemp" type="number" min="0" max="25" step="1" maxlength="2" size="5" value= <?php echo einstellungen('Mindesttemperatur');?> required>
                                    °C
                                    <input type="submit" class="submit" >
                                <label for="hoechsttemp">Höchsttemperatur</label>
                                    <input id="hoechsttemp" name="hoechsttemp" type="number" min="15" max="35" step="1" maxlength="2" size="5" value= <?php echo einstellungen('Höchsttemperatur');?> required>
                                    °C
                                    <input type="submit" class="submit" >
                                    </form>
                                <div class="result">
                            </div>
                        </div>
                    </div>
                    
                    <!-- 3. white block, includes 'Luftfeuchtigkeitseinstellungen': 'Mindestfeuchte' & 'Befeuchtungsdauer'-->
                    <div class="tm-col tm-col-big">
                        <div class="bg-white tm-block h-100">
                            <h2 class="tm-block-title">Luftfeuchtigkeit Einstellungen</h2>
                            <form method="get" action="" id="contactform">
                                <label for="mindestfeuchte">Mindestfeuchtigkeit</label>
                                    <input id="mindestfeuchte" name="mindestfeuchte" type="number" min="50" max="100" step="1" maxlength="3" size="5" value= <?php echo einstellungen('Mindestfeuchtigkeit');?> required>
                                    %
                                    <input type="submit" class="submit" >
                                <label for="befeuchtungsdauer">Befeuchtungsdauer</label>
                                    <input id="befeuchtungsdauer" name="befeuchtungsdauer" type="number" min="5" max="30" step="1" maxlength="2" size="5" value= <?php echo einstellungen('Befeuchtungsdauer');?> required>
                                    min
                                    <input type="submit" class="submit" >
                                    
                                    </form>
                                <div class="result">
                            </div>                                
                        </div>
                    </div>
                    
                    <!-- 4. white block, includes 'Lüftungseinstellungen': 'Lüftungsdauer'-->
                    <div class="tm-col tm-col-big">
                        <div class="bg-white tm-block h-100">
                            <h2 class="tm-block-title">Lüftung Einstellungen</h2>
                            <form method="get" action="" id="contactform">
                                <label for="lueftungsdauer">Lüftungsdauer</label>
                                    <input id="lueftungsdauer" name="lueftungsdauer" type="number" min="5" max="30" step="1" maxlength="2" size="5" value= <?php echo einstellungen('Lüftungsdauer');?> required>
                                    min
                                    <input type="submit" class="submit" >
                                    </form>
                                <div class="result">
                            </div>                
                        </div>
                    </div>
                </div>
                
        <?php
        //------------------------------------------------------------------------------------
        // function to fill the input elements with the current data out of the DB
        // updates when site gets reloaded
        //------------------------------------------------------------------------------------
            
            // get 'einstellungen' out of DB -> write current 'einstellung' value in input element
            function einstellungen(String $Bezeichnung)
                {         
                    // Database Login
                    include "databaseLogin.php";
                    
                    // create table "einstellungen" when the data is submitted for the first time
                    $sql = "CREATE TABLE IF NOT EXISTS einstellungen (
                    ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    Bezeichnung VARCHAR(30) NOT NULL,
                    Wert VARCHAR(8) NOT NULL,
                    Zugriff TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )";
                    $db->exec($sql);
                    
                    $res = $db->prepare('SELECT * FROM einstellungen WHERE Bezeichnung = :Bezeichnung');
                    $res->execute(array(':Bezeichnung' => $Bezeichnung ));

                    while($row = $res->fetch())
                    {
                        $einstellung = $row['Wert'];
                    }
                    return $einstellung;
                }
        ?>  
        
        <!-- java scripts -->  
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/tooplate-scripts.js"></script>
        <script src= "https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- js to submit entered data to the DB -->
        <!-- each white block has a separate js -->
        <script>
            $(document).ready(function () {
                $('.submit').click(function (e) {
                e.preventDefault();
                var lichtende = $('#lichtende').val();
                var lichtstart = $('#lichtstart').val();
                var mindesttemp = $('#mindesttemp').val();
                var hoechsttemp = $('#hoechsttemp').val();
                var mindestfeuchte = $('#mindestfeuchte').val();
                var befeuchtungsdauer = $('#befeuchtungsdauer').val();
                var lueftungsdauer = $('#lueftungsdauer').val();
                
                // Alert window "swal"
                swal({title:'Übermittelte Daten:',
                     text: '\nLichtstart: ' + lichtstart + ' Uhr\nLichtende: ' + lichtende + ' Uhr\nMindesttemperatur: ' + mindesttemp + ' °C\nHöchsttemperatur: ' + hoechsttemp + ' °C\nMindestfeuchtigkeit: ' + mindestfeuchte + ' %\nBefeuchtungsdauer: ' + befeuchtungsdauer + ' min\nLüftungsdauer: ' + lueftungsdauer + ' min', 
                     icon: "success"});      
                $.ajax
                    ({
                    type: "POST",
                    
                    // submit function 
                    url: "form_submit.php",
                    data: { "lichtende": lichtende, "lichtstart": lichtstart, "mindesttemp": mindesttemp, "hoechsttemp": hoechsttemp, "mindestfeuchte": mindestfeuchte, "befeuchtungsdauer": befeuchtungsdauer, "lueftungsdauer": lueftungsdauer},
                    success: function (data) {
                        $('.result').html(data);
                        $('#contactform')[0].reset();
                    }
                    });
                });
            });
        </script>
    </body>
</html>
