<?php
# ConvertMeDammit by Juan L. Sanchez
#
# Call: ConvertMeDammit();
# Arguments: [string] file name 
# Requires: GhostScript
#
# Description: Small function to convert a PDF to multiple sized JPEGs
#
# Written Feb 20th 2009 by Juan L. Sanchez [juan.sanchez@manlawonline.org]
#
# NOTE: Comment out $owner, $group, and exec("chown $owner:$group $dir") if it
# not needed. Also, might want to add some sort of check to the directory if
# using it in a production environment.

function ConvertMeDammit($file, $quality = 600, $dir = "./"){
    $owner = "guest"; # Set the owner of the file
    $group = "guest"; # Set the group to which the file owner belongs to

    # DIRECTORY VALIDATION
    if(!is_dir($dir)) exec("mkdir $dir"); # If directory does not exist, create it
    exec("chmod 777 -R $dir"); # Set permissions to 777
    exec("chown $owner:$group $dir"); # modify the owner:group of the directory
    
    # SET THE VARIABLES
    $sizes = Array("100","300","450","800"); # Sizes to resize the image to
    $filename = explode(".", $file); # Put filename into array via explode
    $pdfFileName = $filename[0] . ".pdf"; # Create the PDF filename
    $jpgFileName = $filename[0] . ".jpg"; # Create the JPG filename
    
    /* EXECUTE THE COMMAND LINES */
    if(exec("gs -sDEVICE=jpeg -r" . $quality . " -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -sOutputFile=" . $jpgFileName . " " . $file)) {
        foreach($sizes as $dimensions){
            # Convert the images
            exec("convert -resize " . $dimensions . "x -quality 100 " . $jpgFileName . " " . $dir .  $dimensions . ".jpg"); 
        }
        @unlink($jpgFileName); # Delete the temporary image file created
    } 
    else throw new Exception('Could not execute properly.');
}

/* To use the function: 
try{
    ConvertMeDammit(the_file, the_quality, the_directory);
} catch(Exception $e){
    echo $e->getMessage();
} */
?>
