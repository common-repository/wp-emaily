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
class WPEmaily
{	
	function WPEmaily()
	{
	}
	
	function getVersion()
	{
		return "0.8";
	}
	
	function init()
	{
		session_start();
	}
	
	function option($key, $value = null)
	{
		if ($value) {
			if (!get_option("wp_emaily_".$key)) {
				add_option("wp_emaily_".$key, $value);
			} else {
				update_option("wp_emaily_".$key, $value);
			}
		} else {
			return get_option("wp_emaily_".$key);
		}
	}
	
	function ids($id = null, $action = "add")
	{
		if ($_SESSION['wp_emaily_ids']) {
			$ids = unserialize($_SESSION['wp_emaily_ids']);
		} else {
			$ids = array();
			$_SESSION['wp_emaily_ids'] = $ids;
		}

		if ($id && $action == "add") {
			$ids[$id] = $id;
			$_SESSION['wp_emaily_ids'] = serialize($ids);
		} 
		elseif ($action == "remove") {
			unset($ids[$id]);
			$_SESSION['wp_emaily_ids'] = serialize($ids);
		}
		else {
			return $ids;
		}

	}
	
	function adverts($array = null, $action = "add")
	{
		if ($_SESSION['wp_emaily_adverts']) {
			$adverts = unserialize($_SESSION['wp_emaily_adverts']);
		} else {
			$adverts = array();
			$_SESSION['wp_emaily_adverts'] = $adverts;
		}

		if ($array && $action == "add") {
			$adverts[htmlentities($array['link'])] = $array;
			$_SESSION['wp_emaily_adverts'] = serialize($adverts);
		} 
		elseif ($action == "remove") {
			unset($adverts[htmlentities($array['link'])]);
			$_SESSION['wp_emaily_adverts'] = serialize($adverts);
		}
		else {
			return $adverts;
		}

	}
	
	function currentAdverts()
	{
		$adverts = WPEmaily::adverts();
		if (count($adverts) > 0) {	
	?>
		<ul>
		<?php foreach ($adverts as $advert): ?>
			<li><a href="<?=WPEMAILY_URL?>/wp-emaily-ajax.php" rel="<?=$advert['link']?>" onclick="wpEmaily.removeAdvert(this);return false;"><?=$advert['link']?></a></li>
		<?php endforeach ?>
		</ul>
	<?php
		} else {
			echo "<p>&larr; Please fill out the form</p>";
		}
	}
	
	function promotionText($text = "")
	{
		if (!empty($text)) {
			$_SESSION['wp_emaily_promotion_text'] = serialize($text);
		} 
		else {
			return stripslashes(unserialize($_SESSION['wp_emaily_promotion_text']));
		}

	}
	
	function titleText($text = "")
	{
		if (!empty($text)) {
			$_SESSION['wp_emaily_title'] = serialize($text);
		} 
		else {
			return stripslashes(unserialize($_SESSION['wp_emaily_title']));
		}

	}

	function selectedArticles()
	{
		$ids = WPEmaily::ids();
		if (count($ids) > 0) {	
	?>
		<ul>
		<?php foreach ($ids as $post): ?>
		<?php $post = get_post($post); ?>
			<li><a href="<?=WPEMAILY_URL?>/wp-emaily-ajax.php?id=<?=$post->ID?>&amp;action=remove" rel="<?=$post->ID?>" onclick="wpEmaily.remove(this);return false;"><?=$post->post_title?></a></li>
		<?php endforeach ?>
		</ul>
	<?php
		} else {
			echo "<p>&larr; Please select an article</p>";
		}
	}

	function availableArticles()
	{	
		$ids = WPEmaily::ids();
		$posts = get_posts('category='.WPEmaily::option('categories').'&numberposts='.WPEmaily::option('article_limit'));
		if (count($posts) > 0) {	
	?>
		<ul>
		<?php foreach ($posts as $post): ?>
		<?php if (in_array($post->ID, $ids)) continue; ?>
			<li><a href="<?=WPEMAILY_URL?>/wp-emaily-ajax.php?id=<?=$post->ID?>" rel="<?=$post->ID?>" onclick="wpEmaily.add(this);return false;"><?=$post->post_title?></a></li>
		<?php endforeach ?>
		</ul>
	<?php
		} else {
			echo "<p>&larr; No Articles available with</p>";
		}
	}
	
	function safeQuery($sql)
	{
	    global $wpdb;

	    $result = $wpdb->query($sql);
	    if ($result === false) {
	        if ($wpdb->error) {
	            $error = $wpdb->error->get_error_message();
	        }
	        else {
	            $error = __('Unknown SQL Error', 'WPEmaily');
	        }
	        die($error);
	    }
	    return $result;
	}

	/**
	 * Initializes the database if it's not already present.
	 */
	function initDatabase()
	{
	    global $wpdb, $userdata;

	    get_currentuserinfo();

	    WPEmaily::safeQuery("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wpemaily` (
	      `id` int(11) NOT NULL auto_increment,
	      `title` varchar(255) NOT NULL,
	      `date_created` DATETIME NOT NULL,
	      `author` varchar(255) NOT NULL,
	      PRIMARY KEY  (`id`)
	    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	
		add_option('wpemaily_table_created', 1);
	}
	
	function insertToDB($data)
	{
	    global $wpdb, $current_user;

	    get_currentuserinfo();

	    $query = "	INSERT INTO {$wpdb->prefix}wpemaily ( `title` , `filename`, `date_created` , `author` )
					VALUES ( '".$data['title']."', '".$data['filename']."',NOW(), '".$current_user->ID."');
					";
		
		$wpdb->query($wpdb->prepare($query));
	}
	
	function createFile($filename, $string, $pre_path = null)
	{
		$filename = $pre_path.$filename;
		if ( ! $fp = @fopen($filename, 'w+')) return false;

		flock($fp, LOCK_EX);
		fwrite($fp, $string);
		flock($fp, LOCK_UN);
		fclose($fp);

		// change file mode
	    chmod($filename, 0755);

		return TRUE;
	}
	
	function readFile ($filename)
	{		
		if ( ! file_exists($filename) || ! $fp = @fopen($filename, 'rb')) {
			return FALSE;
		}
		flock($fp, LOCK_SH);
		
		$dump = '';
		if (filesize($filename) > 0) {
			$dump = fread($fp, filesize($filename)); 
		}
	
		flock($fp, LOCK_UN);
		fclose($fp); 

		return $dump;
	}
	
	/**
	* Force downloads
	*
	* @author Rochak Chauhan
	*/
	function forceDownload($name)
	{
		if(ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }

        // Security checks
        if( $name == "" ) {
            echo "<html><title>Download </title><body><BR><B>ERROR:</B> The download file was NOT SPECIFIED.</body></html>";
            exit;
        }
        elseif ( ! file_exists( $name ) ) {
            echo "<html><title>Download </title><body><BR><B>ERROR:</B> File not found.</body></html>";
            exit;
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=".basename($name).";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($name));
        readfile("$archiveName");
	}
	
	function createFilename($string)
	{
		return md5($string).'.html';
	}
	
	function getThemes()
	{
		$current_theme = WPEmaily::option('theme');
?>
	<ul id="themes" class="float clearfix">
		<?php foreach (WPEmaily::directoryMap(WPEMAILY_PATH . "themes") as $theme): ?>
			<?php if ($current_theme == $theme) {
				$class = "current";
				$title = "Current Theme";
			} else {
				$class = "";
				$title = "Activate Theme";
			} ?>
			<li class="<?php echo $class ?>">
				<a href="<?php echo WPEMAILY_URL ?>/wp-emaily-ajax.php?theme=<?php echo $theme ?>&amp;action=change_theme" title="<?php echo $title ?>" onclick="wpEmaily.changeTheme(this);return false;"><img src="<?php echo WPEMAILY_URL ?>/themes/<?php echo $theme ?>/screenshot.png" /></a>
				<br>
				<a href="<?php echo WPEMAILY_URL ?>/wp-emaily-ajax.php?theme=<?php echo $theme ?>&amp;action=change_theme" title="<?php echo $title ?>" onclick="wpEmaily.changeTheme(this);return false;"><strong><?php echo ucfirst($theme) ?></strong></a>
			</li>
		<?php endforeach ?>
	</ul>
<?php
	}
	
	function getArticles($ids = null)
	{
		$array = array();
		
		if (!$ids) $ids = WPEmaily::ids();
		
		foreach ($ids as $key => $id) {
			$array[$key] = get_post($id);
			if ($image =  WPEmaily::imageByID($id, 'post_title', 'email-image')) {
				$array[$key]->image = $image[0];
			}
		}
		return $array;
	}
	
	function getEmails($where = "", $start = 0, $end = 10)
	{
		global $wpdb;
		
		$emails = $wpdb->get_results( "SELECT SQL_CALC_FOUND_ROWS * FROM ".$wpdb->prefix."wpemaily $where ORDER BY date_created DESC LIMIT $start, $end" );

		$total = $wpdb->get_var( "SELECT FOUND_ROWS()" );

		return array('emails' => $emails, 'total' => $total);
	}
	
	function wordLimit($string, $length = 50, $ellipsis = '&hellip;')
	{
	   return count($words = preg_split('/\s+/', ltrim($string), $length + 1)) > $length ?
		   rtrim(substr($string, 0, strlen($string) - strlen(end($words)))) . $ellipsis :
		   $string;
	}

	function stringLimit($string, $length = 50, $ellipsis = '&hellip;') {
	   return strlen($fragment = substr($string, 0, $length + 1 - strlen($ellipsis))) < strlen($string) + 1 ?
		   preg_replace('/\s*\S*$/', '', $fragment) . $ellipsis : $string;
	}
	
	function paginate_links( $args = '' ) {
		$defaults = array(
			'base' => '%_%', // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
			'format' => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
			'total' => 1,
			'current' => 0,
			'show_all' => false,
			'prev_next' => true,
			'prev_text' => __('&laquo; Previous'),
			'next_text' => __('Next &raquo;'),
			'end_size' => 1, // How many numbers on either end including the end
			'mid_size' => 2, // How many numbers to either side of current not including current
			'type' => 'plain',
			'add_args' => false // array of query args to aadd
		);

		$args = wp_parse_args( $args, $defaults );
		extract($args, EXTR_SKIP);

		// Who knows what else people pass in $args
		$total    = (int) $total;
		if ( $total < 2 )
			return;
		$current  = (int) $current;
		$end_size = 0  < (int) $end_size ? (int) $end_size : 1; // Out of bounds?  Make it the default.
		$mid_size = 0 <= (int) $mid_size ? (int) $mid_size : 2;
		$add_args = is_array($add_args) ? $add_args : false;
		$r = '';
		$page_links = array();
		$n = 0;
		$dots = false;

		if ( $prev_next && $current && 1 < $current ) :
			$link = str_replace('%_%', 2 == $current ? '' : $format, $base);
			$link = str_replace('%#%', $current - 1, $link);
			if ( $add_args )
				$link = add_query_arg( $add_args, $link );
			$page_links[] = "<a class='prev page-numbers' href='" . clean_url($link) . "'>$prev_text</a>";
		endif;
		for ( $n = 1; $n <= $total; $n++ ) :
			if ( $n == $current ) :
				$page_links[] = "<span class='page-numbers current'>$n</span>";
				$dots = true;
			else :
				if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
					$link = str_replace('%_%', 1 == $n ? '' : $format, $base);
					$link = str_replace('%#%', $n, $link);
					if ( $add_args )
						$link = add_query_arg( $add_args, $link );
					$page_links[] = "<a class='page-numbers' href='" . clean_url($link) . "'>$n</a>";
					$dots = true;
				elseif ( $dots && !$show_all ) :
					$page_links[] = "<span class='page-numbers dots'>...</span>";
					$dots = false;
				endif;
			endif;
		endfor;
		if ( $prev_next && $current && ( $current < $total || -1 == $total ) ) :
			$link = str_replace('%_%', $format, $base);
			$link = str_replace('%#%', $current + 1, $link);
			if ( $add_args )
				$link = add_query_arg( $add_args, $link );
			$page_links[] = "<a class='next page-numbers' href='" . clean_url($link) . "'>$next_text</a>";
		endif;
		switch ( $type ) :
			case 'array' :
				return $page_links;
				break;
			case 'list' :
				$r .= "<ul class='page-numbers'>\n\t<li>";
				$r .= join("</li>\n\t<li>", $page_links);
				$r .= "</li>\n</ul>\n";
				break;
			default :
				$r = join("\n", $page_links);
				break;
		endswitch;
		return $r;
	}
	
	function loadTheme( $array, $theme = "" ) {
		if (!$theme) $theme = WPEmaily::option('theme');
		return WPEmaily::load(WPEMAILY_PATH . "/themes/{$theme}/index.php", $array);
	}
	
	function load( $_filename, $array = null ) {
		if ( isset($_filename) && file_exists( $_filename ) ) {

			ob_start();

			global $posts, $post, $wp_did_header, $wp_did_template_redirect, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

			if ( is_array($wp_query->query_vars) )
				extract($wp_query->query_vars, EXTR_SKIP);

			if (is_array($array)) extract($array, EXTR_OVERWRITE);

			require($_filename);

			// get the contents of the file
			$contents = ob_get_contents();

			// clean and flush the output buffer
			ob_end_clean(); //ob_end_flush();

			return $contents;

		} else {
			return 'No page :'.$_filename;
		}

	}
	
	function directoryMap ($source, $top_level_only = FALSE)
	{		
		if ($fp = @opendir($source))
		{ 
			while (FALSE !== ($file = readdir($fp)))
			{
				if (is_dir($source.$file) && substr($file, 0, 1) != '.' && $top_level_only == FALSE) 
				{       
					$temp_array = array();
					 
					$temp_array = WPEmaily::directoryMap($source.$file."/");   
					
					$file_array[$file] = $temp_array;
				}
				elseif (substr($file, 0, 1) != ".")
				{
					$file_array[] = $file;
				}
			}
		}
		return $file_array;
	}
	
	function imageByID($post_id, $like_key = null, $like_value = null)
	{
		$wpdb = $GLOBALS['wpdb'];

		$query = " 	SELECT *
					FROM {$wpdb->posts}
					WHERE post_type = 'attachment' 
					AND (
						post_mime_type = 'image/jpeg'
						OR post_mime_type = 'image/png'
						OR post_mime_type = 'image/gif'
						)
					AND post_parent = ".$post_id;

		if ($not_like_value) $query .= " AND {$like_key} = '{$like_value}%";

		return $wpdb->get_results($wpdb->prepare($query), 'ARRAY_A');
	}
	
	function dateConvert($format, $datestamp)
	{
		if ($datestamp != 0) {
			list($year, $month, $day) = split("-", $datestamp);

			return date($format, mktime(0, 0, 0, $month, $day, $year));
		}
	}
	
}


?>