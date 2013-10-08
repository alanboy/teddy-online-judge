<?php 

    require_once("../../serverside/bootstrap.php");

	function read($lines = 100)
  	{

        if(!file_exists(LOGFILENAME)){
            die("Unable to open logfile:" .LOGFILENAME );
        }

    // $file: Name of file to open
    // $lines: Number of lines to obtain from the end of the file
    // $header: flag to indicate that the file contains a header which should not be included if the number of lines in the file is <= lines
    
    $file = LOGFILENAME;
     $header = null;
    global $error_string;
    
    // Number of lines read per time
    $bufferlength = 1024;
    $aliq = "";
    $line_arr = array();
    $tmp = array();
    $tmp2 = array();
    
    if (!($handle = fopen($file , "r"))) {
        echo("Could not fopen $file");
    }

    if (!$handle) {
        echo("Bad file handle");
        return 0;
    }

    // Get size of file
    fseek($handle, 0, SEEK_END);
    $filesize = ftell($handle);

    $position= - min($bufferlength,$filesize);

    while ($lines > 0) {
        if (fseek($handle, $position, SEEK_END)) {
            echo("Could not fseek");
            return 0;
        }
        
        unset($buffer);
        $buffer = "";
        // Read some data starting fromt he end of the file
        if (!($buffer = fread($handle, $bufferlength))) {
            echo("Could not fread");
            return 0;
        }
        
        // Split by line
        $cnt = (count($tmp) - 1);
        for ($i = 0; $i < count($tmp); $i++ ) {
            unset($tmp[0]);
        }
        unset($tmp);
        $tmp = explode("\n", $buffer);
        
        // Handle case of partial previous line read
        if ($aliq != "") {
            $tmp[count($tmp) - 1] .= $aliq;
        }

        unset($aliq);
        // Take out the first line which may be partial
        $aliq = array_shift($tmp);
        $read = count($tmp);
        
        // Read too much (exceeded indicated lines to read)
        if ($read >= $lines) {
            // Slice off the lines we need and merge with current results
            unset($tmp2);
            $tmp2 = array_slice($tmp, $read - $lines);
            $line_arr = array_merge($tmp2, $line_arr);
            
            // Discard the header line if it is there
            if ($header &&
                (count($line_arr) <= $lines)) {
                array_shift($line_arr);
            }

            // Break the loop
            $lines = 0;
        }
        // Reached start of file
        elseif (-$position >= $filesize) {
            // Get back $aliq which contains the very first line of the file
            unset($tmp2);
            $tmp2[0] = $aliq;
            
            $line_arr = array_merge($tmp2, $tmp, $line_arr);
            
            // Discard the header line if it is there
            if ($header &&
                (count($line_arr) <= $lines)) {
                array_shift($line_arr);
            }

            // Break the loop
            $lines = 0;
        }
        // Continue reading
        else {
            // Add the freshly grabbed lines on top of the others
            $line_arr = array_merge($tmp, $line_arr);
            $lines -= $read;

            // No longer a full buffer's worth of data to read
            if ($position - $bufferlength < -$filesize) {
                $bufferlength = $filesize + $position;
                $position = -$filesize;                    
            }
            // Still >= $bufferlength worth of data to read
            else {
                $position -= $bufferlength;
            }
        }
    }
    
    fclose($handle);

    return $line_arr;
    
  }
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/teddy_style.css" />
    		<title>Admin - Ejecuciones</title>
			<script src="../js/jquery.min.js"></script>
			<script src="../js/jquery-ui.custom.min.js"></script>
	</head>
<body>

<div class="wrapper">
	<div class="header">
		<h1>teddy online judge</h1>
		<h2>teddy es un oso de peluche</h2>
	</div>

   	<?php include_once("../includes/admin.menu.php"); ?>

	<div class="post_blanco">
	<?php
		$lines =  read(1500);

		echo "<pre style='overflow: hidden; padding: 5px; width: 100%; background: whiteSmoke; margin-bottom:5px; font-size:9.5px;'>";

		for($a = sizeof($lines) - 1; $a >= 0 ; $a-- ){
		    $linea = explode(  "|", $lines[$a] );

			if( sizeof($linea) > 1 ){
				$ip = $linea[1];
				$octetos = explode(".", $ip);
				
				echo "<div style='color: white; background-color: rgb( " . $octetos[1] . " , " . $octetos[2] . " , " . $octetos[3] . ")'>" . $lines[$a] . "\n</div>" ;		
						
			}else{
				
				echo "<div>" . $lines[$a] . "\n</div>" ;		
			}
		}
		echo "</pre>";


	?>


	</div>





	<?php include_once("../includes/footer.php"); ?>

</div>
<?php include("../includes/ga.php"); ?>
</body>
</html>
