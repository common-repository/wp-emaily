<?php
/*
Plugin Name: WP Emaily
Plugin URI: http://www.halmatferello.com/lab/wp-emaily/
Description: Email creation plugin - allows you to select specific articles to be included into an email template.
Author: Halmat Ferello
Author URI: http://www.halmatferello.com
Version: 0.8

Copyright (C) 2009 Halmat Ferello

Released under the GPL v.2, http://www.gnu.org/copyleft/gpl.html

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

require_once('wp-emaily-config.php');
require_once('wp-emaily-class.php');

class WPEmailyPages extends WPEmaily
{
	function WPEmailyPages()
	{
		WPEmaily::WPEmaily();
	}
	
	function menus()
	{
		add_menu_page('WP Emaily', 'WP Emaily', 8, __FILE__, array('WPEmailyPages', 'homePage'));
		add_submenu_page(__FILE__, 'WP Emaily : Create Email', 'Create Email', 8, 'create-email', array('WPEmailyPages', 'createEmail'));
		add_submenu_page(__FILE__, 'WP Emaily : Themes', 'Themes', 8, 'Themes', array('WPEmailyPages', 'themes'));
		add_submenu_page(__FILE__, 'WP Emaily : Settings', 'Settings', 8, 'Settings', array('WPEmailyPages', 'settings'));
	}
		
	function homePage()
	{
		echo WPEmailyPages::loadPage(__FUNCTION__);
	}

	function createEmail()
	{		
		$data = array();
		if ($_POST) {
			$email = array();
			
			$email['title'] = WPEmaily::titleText();
			$email['filename'] = WPEmaily::createFilename($email['title'].mktime());
			
			$email['url'] = WPEMAILY_URL.'/themes/'.WPEmaily::option('theme').'/';
			$email['promotion'] = WPEmaily::promotionText();
			
			$email['articles'] = WPEmaily::getArticles();
			
			$email['adverts'] = WPEmaily::adverts();
			$email['emailLink'] = WPEMAILY_URL.'/emails/'.$email['filename'];
			
			if ($email['articles'][0]->post_excerpt) {
				$email['outlookPreview'] = $email['title']." - ".$email['articles'][0]->post_excerpt;
			} else {
				$email['outlookPreview'] = $email['title']." - ".WPEmaily::wordLimit($email['articles'][0]->post_content, WPEmaily::option('word_limit'));
			}

			// create HTML email
			$emailHTML = WPEmaily::loadTheme($email);
			
			WPEmaily::createFile($email['filename'], $emailHTML, WPEMAILY_PATH.'emails/');
			
			// insert into database
			WPEmaily::insertToDB($email);
			
			$data['message'] = 'Email created. <a href="'.WPEMAILY_URL.'/wp-emaily-zip-creation.php?filename='.$email['filename'].'">Download email (ZIP)</a>.';			
		}
		
		unset($_SESSION['wp_emaily_ids']);
		unset($_SESSION['wp_emaily_promotion_text']);
		unset($_SESSION['wp_emaily_adverts']);
		echo WPEmailyPages::loadPage(__FUNCTION__, $data);
	}
	
	function settings()
	{
		if ($_REQUEST) {
			WPEmaily::option('article_limit', $_REQUEST['wp_emaily_article_limit']);
			WPEmaily::option('word_limit', $_REQUEST['wp_emaily_word_limit']);

			if (count($_REQUEST['post_category']) > 1) {
				WPEmaily::option('categories', implode(',', $_REQUEST['post_category']));
			} else {
				WPEmaily::option('categories', $_REQUEST['post_category'][0]);
			}
		}
		
		$data['categories'] = explode(',', WPEmaily::option('categories'));
		$data['word_limit'] = WPEmaily::option('word_limit');
		$data['article_limit'] = WPEmaily::option('article_limit');
		
		echo WPEmailyPages::loadPage(__FUNCTION__, $data);
	}
	
	function themes()
	{
		echo WPEmailyPages::loadPage(__FUNCTION__);
	}
	
	function loadPage( $_filename, $array = null ) {
		return WPEmaily::load(WPEMAILY_PATH . "html/".$_filename.'.php', $array);
	}
}

add_action('admin_menu', array('WPEmailyPages', 'menus'));

if(defined('ABSPATH') && defined('WPINC')) {
	add_action("init",array("WPEmaily","init"),1000,0);
	
	// so this doesn't get run again
	if (get_option('wpemaily_table_created') != 1) WPEmaily::initDatabase();
}

?>