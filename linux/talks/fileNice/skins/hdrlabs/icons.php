<?php
header('Content-type: text/css');

include("../../prefs.php");

$icons = array("gif"=>"file.gif",
                "jpg"=>"file.gif",
                "jpeg"=>"file.gif",
                "bmp"=>"file.gif",
                "png"=>"file.gif",

                "mp3"=>"file.gif",
                "mov"=>"file.gif",
                "aif"=>"file.gif",
                "aiff"=>"file.gif",
                "wav"=>"file.gif",
                "swf"=>"file.gif",
                "mpg"=>"file.gif",
                "avi"=>"file.gif",
                "mpeg"=>"file.gif",
                "mid"=>"file.gif",
                "wmv"=>"file.gif",
                                
                "html"=>"file.gif",
                "htm"=>"file.gif",
                "txt"=>"file.gif",
                "css"=>"file.gif",
                
                "php"=>"file.gif",
                "php3"=>"file.gif",
                "php4"=>"file.gif",
                "asp"=>"file.gif",
                "js"=>"file.gif",
                
                "pdf"=>"file.gif",
                "doc"=>"file.gif",
                "zip"=>"file.gif",
                "sit"=>"file.gif",
                "rar"=>"file.gif",
                "rm"=>"file.gif",
                "ram"=>"file.gif",
                "ibl"=>"file.gif",                
                "sIBLT"=>"file.gif"                
                );
                

$allFiles = array(); 
for($i=0; $i<count($imgTypes); $i++){
	array_push($allFiles,$imgTypes[$i]);	
}	
for($i=0; $i<count($embedTypes); $i++){
	array_push($allFiles,$embedTypes[$i]);	
}	
for($i=0; $i<count($htmlTypes); $i++){
	array_push($allFiles,$htmlTypes[$i]);	
}	
for($i=0; $i<count($phpTypes); $i++){
	array_push($allFiles,$phpTypes[$i]);	
}
for($i=0; $i<count($miscTypes); $i++){
	array_push($allFiles,$miscTypes[$i]);	
}	
              
function addArray(&$array, $key, $val)
{
   $tempArray = array($key => $val);
   $array = array_merge ($array, $tempArray);
}

// add the default file.gif icon for any file type thatr doesn't have an 
// icon set in the list above
for($i = 0; $i<count($allFiles);$i++){
	if(!isset($icons[$allFiles[$i]])){
		addArray($icons,$allFiles[$i], "file.gif");
	}	
}
                
                
foreach($icons as $key => $value){
    echo "
li.file.icon_$key{ background:#2d3034 url(\"icons/$value\") 2px 2px no-repeat; }
li.file_open.icon_$key{ background:#DDC url(\"icons/$value\") 2px 2px no-repeat; }
";
}


?> 