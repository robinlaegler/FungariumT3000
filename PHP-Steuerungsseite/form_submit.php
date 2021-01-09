<?php
    //-----------------------------------------------------------
    // submit new entered data (form) to DB
    //-----------------------------------------------------------
    
    if(isset($_POST['lichtende']) || isset($_POST['lichtstart']) || isset($_POST['mindesttemp'])|| isset($_POST['hoechsttemp']) || isset($_POST['mindestfeuchte'])|| isset($_POST['befeuchtungsdauer']) || isset($_POST['lueftungsdauer'])){

        // new data submitted by User
        $wertLichtstart =  $_POST['lichtstart']; 
        $wertLichtende = $_POST['lichtende'];
        $wertMindesttemp =  $_POST['mindesttemp'];
        $wertHoechsttemp = $_POST['hoechsttemp'];
        $wertMindestfeuchte =  $_POST['mindestfeuchte'];
        $wertdauer = $_POST['befeuchtungsdauer'];
        $wertLueftungsdauer =  $_POST['lueftungsdauer'];
                
        // Database Login
        include_once "databaseLogin.php";

        // write new data in the table
        $db->query("DELETE FROM einstellungen WHERE Bezeichnung='Lichtstart'"); // delete old data
        $sql =  $db->prepare("INSERT INTO einstellungen (ID,Bezeichnung,Wert) VALUES (:ID, :Bezeichnung, :Wert)");
        $sql->execute(array('ID' => 1, 'Bezeichnung' => 'Lichtstart', 'Wert' => $wertLichtstart)); // write new data 
        
        $db->query("DELETE FROM einstellungen WHERE Bezeichnung='Lichtende'"); // delete old data
        $sql =  $db->prepare("INSERT INTO einstellungen (ID,Bezeichnung,Wert) VALUES (:ID, :Bezeichnung, :Wert)");
        $sql->execute(array('ID' => 2, 'Bezeichnung' => 'Lichtende', 'Wert' => $wertLichtende)); // write new data   

        // write new data in the table
        $db->query("DELETE FROM einstellungen WHERE Bezeichnung='Mindesttemperatur'"); // delete old data
        $sql =  $db->prepare("INSERT INTO einstellungen (ID,Bezeichnung,Wert) VALUES (:ID, :Bezeichnung, :Wert)");
        $sql->execute(array('ID' => 3, 'Bezeichnung' => 'Mindesttemperatur', 'Wert' => $wertMindesttemp)); // write new data   
        
        $db->query("DELETE FROM einstellungen WHERE Bezeichnung='Höchsttemperatur'"); // delete old data
        $sql =  $db->prepare("INSERT INTO einstellungen (ID,Bezeichnung,Wert) VALUES (:ID, :Bezeichnung, :Wert)");
        $sql->execute(array('ID' => 4, 'Bezeichnung' => 'Höchsttemperatur', 'Wert' => $wertHoechsttemp)); // write new data           
        // reload site
        
        // write new data in the table
        $db->query("DELETE FROM einstellungen WHERE Bezeichnung='Mindestfeuchtigkeit'"); // delete old data
        $sql =  $db->prepare("INSERT INTO einstellungen (ID,Bezeichnung,Wert) VALUES (:ID, :Bezeichnung, :Wert)");
        $sql->execute(array('ID' => 5, 'Bezeichnung' => 'Mindestfeuchtigkeit', 'Wert' => $wertMindestfeuchte)); // write new data   
        
        $db->query("DELETE FROM einstellungen WHERE Bezeichnung='Befeuchtungsdauer'"); // delete old data
        $sql =  $db->prepare("INSERT INTO einstellungen (ID,Bezeichnung,Wert) VALUES (:ID, :Bezeichnung, :Wert)");
        $sql->execute(array('ID' => 6, 'Bezeichnung' => 'Befeuchtungsdauer', 'Wert' => $wertdauer)); // write new data  
        
        // write new data in the table
        $db->query("DELETE FROM einstellungen WHERE Bezeichnung='Lueftungsdauer'"); // delete old data
        $sql =  $db->prepare("INSERT INTO einstellungen (ID,Bezeichnung,Wert) VALUES (:ID, :Bezeichnung, :Wert)");
        $sql->execute(array('ID' => 7, 'Bezeichnung' => 'Lüftungsdauer', 'Wert' => $wertLueftungsdauer)); // write new data   
        
        echo "<script type='text/javascript'>location.reload();</script>";
    }
?>
