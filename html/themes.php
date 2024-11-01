<?php include('css.php') ?>
<style type="text/css" media="screen">
	ul#themes li {
		margin: 8px 22px 8px 0;
		padding: 8px;
		border: 1px solid #ccc;
		width: 150px; height: 170px;
		position: relative;
	}
	ul#themes li.current {
		border: 1px solid #f00;
	}
	div#wp_emaily_loading span {
		background: url('<?php echo WPEMAILY_URL; ?>/images/spinner.gif') no-repeat center left;
		padding-left: 20px;
	}
	
	div#wp_emaily_loading {
		background: #fff;
		display: block;
		position: absolute;
		padding: 12px 12px 12px 12px;
		border: 1px solid #ccc;
		text-align: center;
		width: 424px; 
		z-index: 99;
		top: 0; left: 0;
		width: 140px; height: 160px;
	}
</style>
<div id="wp_emaily" class="wrap">
	<h2>Themes</h2>
	<div id="wp_emaily_themes">
		<?php WPEmaily::getThemes(); ?>
	</div>
	
</div>

<script type="text/javascript" charset="utf-8">

	var wpEmaily = {};
	
	wpEmaily.changeTheme = function (a) {
		
		jQuery('div#wp_emaily_themes li a').parents('li').removeClass('current');
		
		setTimeout(function() {
			jQuery(a).parents('li').addClass('current');
			a.title = 'Current Theme';
		}, 500)
		
		jQuery.ajax({
			url: a.href+'&ajax=true',
			type: 'GET',
			
			beforeSend: function() {
				jQuery(a).parents('li').prepend('<div id="wp_emaily_loading"></div>');
				jQuery('#wp_emaily_loading').hide();
				jQuery('#wp_emaily_loading').html('<span>Changing Theme</span>').fadeIn('fast');
			},

			complete: function() {
				jQuery('#wp_emaily_loading').fadeOut('fast',
				function() {
					jQuery(this).remove();
				});
			},

			success: function(txt) {
				jQuery('#wp_emaily_themes_list').html(txt);
			},

			error: function() {
			//called when there is an error
			}
		});
		
		return false;
		
	};
	
</script>