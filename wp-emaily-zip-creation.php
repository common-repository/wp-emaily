<?php
/*
Copyright (C) 2009 Halmat Ferello

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
if(ini_get('zlib.output_compression')) {
    ini_set('zlib.output_compression', 'Off');
}

require_once('../../../wp-config.php');
require_once('../../../wp-admin/includes/admin.php');
require_once('wp-emaily-config.php');
require_once('wp-emaily-class.php');
require_once('zipfile.php');

$zipfile = new zipfile();  
$dir = 'email';
$filedata = WPEmaily::readFile(WPEMAILY_PATH.'emails/'.$_GET['filename']);

// add the subdirectory ... important!
$zipfile -> add_dir($dir);

// add the binary data stored in the string 'filedata'
$zipfile -> add_file($filedata, $dir."/index.html");  

// the next three lines force an immediate download of the zip file:
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: application/zip");
header("Content-disposition: attachment; filename={$_GET['filename']}.zip");  
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($name));

echo $zipfile -> file();  


// OR instead of doing that, you can write out the file to the loca disk like this:
// $filename = "output.zip";
// $fd = fopen ($filename, "wb");
// $out = fwrite ($fd, $zipfile -> file());
// fclose ($fd);

// then offer it to the user to download:
?>