<!DOCTYPE html>
<html lang="de">
    
<!-- Site: 'Manuell' -->

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
                            <h2 class="tm-block-title">Manueller Betrieb</h2>
                                                            
                                <label for="appt1" method>Auto/Manuell:</label>
                                <!-- Rounded switch -->
                                <label class="switch">
                                  <input type="checkbox">
                                  <span class="slider round"></span>
                                </label>
                                <label for="appt1" method>Manueller Betrieb Zeit:</label>
                                <div class="slidecontainer">
                                  <input type="range" min="1" max="100" value="50" class="slidersss" id="myRange">
                                </div>      
                        </div>
                    </div>
                <!-- 1. white block, includes 'Lichteinstellungen': 'Lichtstart' & 'Lichtende'-->
                    <div class="tm-col tm-col-big">
                        <div class="bg-white tm-block h-100">
                            <h2 class="tm-block-title">Manueller Aktorbetrieb</h2>                    
                                <label for="appt1" method>Licht:</label>
                                <!-- Rounded switch -->
                                <label class="switch">
                                  <input type="checkbox">
                                  <span class="slider round"></span>
                                </label>
                                
                                <label for="appt1" method>Heizung:</label>
                                <!-- Rounded switch -->
                                <label class="switch">
                                  <input type="checkbox">
                                  <span class="slider round"></span>
                                </label>     

                                <label for="appt1" method>Kühlung:</label>
                                <!-- Rounded switch -->
                                <label class="switch">
                                  <input type="checkbox">
                                  <span class="slider round"></span>
                                </label>   

                                <label for="appt1" method>Fogger:</label>
                                <!-- Rounded switch -->
                                <label class="switch">
                                  <input type="checkbox">
                                  <span class="slider round"></span>
                                </label>     
                                
                                <label for="appt1" method>Lüftung:</label>
                                <!-- Rounded switch -->
                                <label class="switch">
                                  <input type="checkbox">
                                  <span class="slider round"></span>
                                </label>     
                            </div>
                        </div>
                        
                        <div class="tm-col tm-col-big">
                        <div class="bg-white tm-block h-100">
                            <h2 class="tm-block-title">Manueller Sensorneustart</h2>
                                                            
                                <label for="appt1" method>Sensorneustart</label>
                                    <input type="submit" class="submit">
                        </div>
                    </div>
                    </div>
            </div>
            
              

        <!-- java scripts -->  
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/tooplate-scripts.js"></script>
        
        <!-- js to submit entered data to the DB -->
        <!-- each white block has a separate js -->
        <script>
            function goPython(){
                $.ajax
                    ({
                    url: "mydht_test.py",
                    context: document.body
                    }).done(function() {
                        alert('Finished python script');;
                    });
                }
        </script>
        <script>
            var slider = document.getElementById("myRange");
            var output = document.getElementById("demo");
            output.innerHTML = slider.value; // Display the default slider value

            // Update the current slider value (each time you drag the slider handle)
            slider.oninput = function() {
              output.innerHTML = this.value;
            }
        </script>
    </body>
</html>
