<?php

/* ------------------------------------------------------------------

iOS Rotation Correction
v1.0, 12-Jul-2018
github.com/scrow/iosrotate
Steve Crow, scrow@sdf.org

Main application

--------------------------------------------------------------------- */

require_once('config.inc.php');

if(!file_exists($out_path)) {
	shell_exec('mkdir -p ' . $out_path);
};

// Quick cleanup - remove any files over 5 minutes old
$file_list = glob($out_path . '*.tiff');
foreach($file_list as $this_file) {
	if(is_file($this_file)) {
		if(time() - filemtime($this_file) >= 120) {
			unlink($this_file);
		};
	};
};

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Show the input form
	?><HTML>
		<HEAD>
			<META NAME="viewport" CONTENT="width=device-width,initial-scale=1.0"/>
		</HEAD>
        <BODY>
			<H1>iOS Rotation Correction</H1>
		
			<P>This utility will "correct" rotation of iOS photos based on embedded EXIF data.  Output file will be the same format as the input file and some loss of quality will occur.  For best quality output, force TIFF output.  Otherwise, you will receive a file in JPEG format, which is likely what you are uploading here.</P>
		
			<P>Select your file and click "Upload." Right-click or long-tap on the output image and select Save in your browser.<P>
				
            <FORM ACTION="<?php echo basename(__FILE__);?>" METHOD="POST" ENCTYPE="multipart/form-data">
                <INPUT TYPE="file" NAME="infile" ACCEPT="image/*"> <INPUT TYPE="submit" VALUE="Upload"/>
                <BR/><INPUT TYPE="CHECKBOX" VALUE="1" NAME="force_tiff"/> Force TIFF output
            </FORM>
            
            <HR>
            
            <ADDRESS><A HREF="http://github.com/scrow/iosrotate">iOS Rotation Correction</A> v1.0, 12-Jul-2018 by Steve Crow, <A HREF="mailto:scrow@sdf.org">scrow@sdf.org</A></ADDRESS>
        </BODY>
        <?php
        break;
    case 'POST':
        // Process and send the file
        if($_FILES['infile']['name']) {
            if(!$_FILES['infile']['error']) {
                $path_parts = pathinfo($_FILES['infile']['tmp_name']);
                if(isset($_POST['force_tiff']) && ($_POST['force_tiff']==1)) {
                	$output_filename = $path_parts['basename'] . '.tiff';
                } else {
                	$output_filename = $path_parts['basename'] . '.jpg';
                };
                $convert_cmd .= ' ' . $_FILES['infile']['tmp_name'] . ' -auto-orient -quality 100% ' . $out_path . $output_filename;
                shell_exec($convert_cmd);
                chmod($out_path . $output_filename, 750);
                unlink($_FILES['infile']['tmp_name']);
				header('Location: ' . $out_url . $output_filename);
           };
		};
        break;
    default:
        echo('Unsupported request type.');
	die();
        break;
};
?>
