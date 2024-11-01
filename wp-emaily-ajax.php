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

require_once('../../../wp-config.php');
require_once('../../../wp-admin/includes/admin.php');
require_once('wp-emaily-config.php');
require_once('wp-emaily-class.php');

if ($_GET['action'] == "add" && $_GET['id']) {
	WPEmaily::ids($_GET['id']);
	WPEmaily::selectedArticles();
}
else if ($_GET['action'] == "remove" && $_GET['id']) {
	WPEmaily::ids($_GET['id'], "remove");
	WPEmaily::selectedArticles();
}
else if ($_GET['action'] == "available" && $_GET['id']) {
	WPEmaily::availableArticles();
}
else if($_GET['action'] == "promotion_text") {
	WPEmaily::promotionText($_GET['wp_emaily_promotion_text']);
	echo WPEmaily::promotionText();
}
else if($_GET['action'] == "title") {
	WPEmaily::titleText($_GET['wp_emaily_title']);
	echo WPEmaily::titleText();
}
else if ($_GET['action'] == "add_advert" && preg_match('/\.jpg$|\.jpeg$/', $_GET['wp_emaily_advert_image'])) {
	$array = array(
		'image' => $_GET['wp_emaily_advert_image'],
		'link' =>  $_GET['wp_emaily_advert_link']
	);
	WPEmaily::adverts($array);
	WPEmaily::currentAdverts();
}
else if ($_GET['action'] == "remove_advert") {
	$array = array(
		'link' =>  $_GET['wp_emaily_advert_link']
	);
	WPEmaily::adverts($array, "remove");
	WPEmaily::currentAdverts();
}
else if ($_GET['action'] == "change_theme") {
	WPEmaily::option('theme', $_GET['theme']);
	WPEmaily::getThemes();
}


if (!$_GET['ajax']) {
	wp_redirect($_SERVER['HTTP_REFERER']);
}

?>
