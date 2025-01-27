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
	
	$data = array();
	$data['title'] = WPEmaily::titleText();
	$data['url'] = WPEMAILY_URL.'/themes/'.WPEmaily::option('theme').'/';
	$data['promotion'] = WPEmaily::promotionText();
	$data['articles'] = WPEmaily::getArticles();
	$data['adverts'] = WPEmaily::adverts();
	//print_r($data);
	echo WPEmaily::loadTheme($data);
?>
