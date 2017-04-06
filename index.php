<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="css/printersGen.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        
        $filePointer = fopen("printers.txt", "r");
        
        $ips = array();
        $printerTypes = array();
        $buildings = array();
        $roomNumbers = array();
        
        $printersInBuilding = array();
        
        while(!feof($filePointer)) {
            
            $line = rtrim(fgets($filePointer));
            
            if($line) {
                
                list($ipAddress, $host, $printerType, $building, $roomNumber) = explode(",", $line);
                
                $ips[$host] = $ipAddress;
                $printerTypes[$host] = $printerType;
                $buildings[$host] = $building;
                $roomNumbers[$host] = $roomNumber;
                
                if(!isset($printersInBuilding[$building])) {
                    
                    $printersInBuilding[$building] = 0;
                    
                }
                
                $printersInBuilding[$building]++;
            }
            
        }
        
        foreach($printersInBuilding as $building=>$numberOfPrinters) {
          
                // mark up each table
                echo <<<TABLE
                <table>
                    <tr class="firstRow">
                        <td colspan="3">
                            <span class="headerTxt">$building</span>
                        </td>
                        <td>
                            # of printers = $numberOfPrinters
                        </td>
                    </tr>
TABLE;
                
                //write the table rows
                foreach($ips as $host=>$ipAddress) {
                    
                    if ($building == $buildings[$host]) {
                        
                        if($printerTypes[$host] == "Lexmark") {
                            $className = "lexmark";
                        } else if($printerTypes[$host] == "HP LaserJet") {
                            $className = "laserJet";
                        } else if ($printerTypes[$host] == "Epson") {
                            $className = "epson";
                        } else {
                            $className = "other";
                        }
                        
                        echo <<<TABLEROW
                        
                        <tr>
                            <td class="$className">$host</td>
                            <td>$ipAddress</td>
                            <td>$printerTypes[$host]</td>
                            <td>$roomNumbers[$host]</td>
                        </tr>
TABLEROW;
                    
                    }
                }
        
                echo"</table>";
        }// end of for each building
        
        ?>
        
    </body>
</html>
