<?php include('css.php') ?>
<style type="text/css" media="screen">
	div.container {
		border: 1px solid #ccc;
		height: 350px;
		overflow-x: hidden;
		overflow-y: auto;
	}
	
	div.container ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
	}
	
	div.container li {
		margin: 0;
		padding-right: 12px;
		border-bottom: 1px solid #ccc;
	}
	
	div.container a {
		display: block;
		padding: 12px 15px;
		text-decoration: none;
	}
	
	div#articles h3, div#adverts h3 {
		margin-top: 0;
	}
	
	div#wp_emaily_available_articles a:hover {
		background: url('<?php echo WPEMAILY_URL; ?>/images/add.png') no-repeat center right;
		color: #1CCD00;
	}
	
	div#wp_emaily_selected_articles p {
		color: #999;
		font-size: 1.4em;
		margin: 150px 0 0 100px;
	}
	div#wp_emaily_selected_articles a:hover, div#wp_emaily_current_adverts a:hover {
		background: url('<?php echo WPEMAILY_URL; ?>/images/delete.png') no-repeat center right;
		color: #f00;
	}
	
	.spinner, div#wp_emaily_loading span, div#wp_emaily_loading2 span {
		background: url('<?php echo WPEMAILY_URL; ?>/images/spinner.gif') no-repeat center left;
		padding-left: 20px;
	}
	
	div#wp_emaily_loading, div#wp_emaily_loading2 {
		background: #fff;
		display: block;
		position: absolute;
		padding: 12px 12px 12px 12px;
		border: 1px solid #ccc;
		text-align: center;
		width: 424px; 
		z-index: 99;
	}
	div#wp_emaily_loading {
		height: 326px;
	}
	div#wp_emaily_loading2 {
		height: 188px;
	}
	div#wp_emaily_loading span, div#wp_emaily_loading2 span {
		display: block;
		font-size: 18px;
		font-weight: bold;
		margin: 150px auto 0px auto;
		width: 210px;
	}
	div#wp_emaily_loading2 span {
		margin-top: 90px;
		width: 150px;
	}
	div.wp_emaily_loading_remove {
		left: 495px !important
	}
	div.wp_emaily_loading_remove span {
		width: 240px !important
	}
	
	#wp_emaily_textarea_progress {
		position: relative;
		display: block;
	}
	#wp_emaily_textarea_progress strong {
	
	}
	
	textarea#wp_emaily_promotion_text {
		width: 440px;
	}
	input#wp_emaily_title {
		font-size: 1.5em;
		width: 600px;
	}
	
	div#wp_emaily_add_advert {
		padding: 0 12px 12px 12px;
		height: 200px;
	}
	div#wp_emaily_add_advert a {
		display: inline;
		padding: 3px 5px;
	}
	
	div#wp_emaily_current_adverts {
		height: 212px;
	}
	div#wp_emaily_current_adverts p {
		color: #999;
		font-size: 1.4em;
		margin: 90px 0 0 100px;
	}
</style>

<div id="wp_emaily" class="wrap">
	
<?php if ($message): ?>
	<div id="message" class="updated fade">
		<p><?php echo $message ?></p>
	</div>
<?php endif ?>
	
<form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
	<h2>Create Email</h2>
	
	<h3>Title</h3>
	<small id="wp_emaily_title_progress">The header and title of your email</small>
	<input type="text" name="wp_emaily_title" id="wp_emaily_title" maxlength="255" />
	
	<hr />
	
	<div class="layout half" id="articles">
		<div class="column column-1">
			<h3>Available articles</h3>
			<small><?=WPEmaily::option('article_limit')?> articles by date order.</small>
			<div id="wp_emaily_available_articles" class="container">
				<?php WPEmaily::availableArticles(); ?>
			</div>
			
		</div>
		<div class="column column-2">
			<h3>Selected articles</h3>
			
			<small>These articles will go into your email.</small>
			<div id="wp_emaily_selected_articles" class="container">
				<p>&larr; Please select an article</p>
			</div>			
		</div>
	</div>
	
	<hr />
	
	<h3>Promotion text</h3>
	<small id="wp_emaily_textarea_progress">Optional feature &ndash; can be used to promote something.</small>
	<textarea name="wp_emaily_promotion_text" id="wp_emaily_promotion_text" rows="8" cols="52"></textarea>
	
	<hr />
	
	<div class="layout half" id="adverts">
		<div class="column column-1">
			<h3>Add an advert</h3>
			<small>You can add multiple adverts</small>
			<div id="wp_emaily_add_advert" class="container">
				<p>
					<label for="wp_emaily_advert_image">Image</label>
					<input type="text" name="wp_emaily_advert_image" id="wp_emaily_advert_image" size="50" />
					<small class="warning">Only accepts JPEG images - example: http://www.sponsorwebsite.com/advert.jpg</small>
				</p>
				<p>
					<label for="wp_emaily_advert_link">Click through link</label>
					<input type="text" name="wp_emaily_advert_link" id="wp_emaily_advert_link" size="50" />
					<small>Example: http://www.sponsorwebsite.com</small>
				</p>
				
				<a class="button-secondary" href="<?=WPEMAILY_URL?>/wp-emaily-ajax.php" id="wp_emaily_advert_submit" onclick="wpEmaily.addAdvert(this);return false;">Add advert</a>
			</div>
			
		</div>
		<div class="column column-2">
			<h3>Current adverts</h3>
			
			<small>The current adverts that will go into your email.</small>
			<div id="wp_emaily_current_adverts" class="container">
				<p>&larr; Please fill out the form</p>
			</div>			
		</div>
	</div>
	
	<hr class="end" />
	<p>
		<input type="submit" class="button" value="Create Email" /> &nbsp;&nbsp; or &nbsp;&nbsp; <a class="button-secondary" href="<?=WPEMAILY_URL?>/wp-emaily-preview.php" target="_blank">Preview email</a>
	</p>
	
</form><!-- form closes -->	
</div>
<script type="text/javascript" charset="utf-8">

	var wpEmaily = {};
	
	jQuery('#wp_emaily_available_articles').before('<div id="wp_emaily_loading"></div>');
	jQuery('#wp_emaily_add_advert').before('<div id="wp_emaily_loading2"></div>');
	jQuery('#wp_emaily_loading,#wp_emaily_loading2').hide();
	
	jQuery('input#wp_emaily_title').blur(function() {
		jQuery.ajax({
			url: '<?=WPEMAILY_URL?>/wp-emaily-ajax.php?&ajax=true&action=title',
			type: 'GET',
			data: "wp_emaily_title="+escape(jQuery('input#wp_emaily_title').val()),

			complete: function() {
			},

			success: function(txt) {
				jQuery('#wp_emaily_title_progress').append(' <strong>Saved</strong>');
				setTimeout(function() {
					jQuery('#wp_emaily_title_progress strong').fadeOut('slow', function() {
						jQuery(this).remove();
					})
				}, 1000);
			},

			error: function() {
			//called when there is an error
			}
		});
	});
	
	jQuery('textarea#wp_emaily_promotion_text').blur(function() {
		jQuery.ajax({
			url: '<?=WPEMAILY_URL?>/wp-emaily-ajax.php?&ajax=true&action=promotion_text',
			type: 'GET',
			data: "wp_emaily_promotion_text="+escape(jQuery('textarea#wp_emaily_promotion_text').val()),

			complete: function() {
			},

			success: function(txt) {
				jQuery('#wp_emaily_textarea_progress').append(' <strong>Saved</strong>');
				setTimeout(function() {
					jQuery('#wp_emaily_textarea_progress strong').fadeOut('slow', function() {
						jQuery(this).remove();
					})
				}, 1000);
			},

			error: function() {
			//called when there is an error
			}
		});
	});
	
	wpEmaily.add = function (a) {
		
		jQuery.ajax({
			url: a.href+'&ajax=true&action=add',
			type: 'GET',
			
			beforeSend: function() {
				jQuery('#wp_emaily_loading').removeClass('wp_emaily_loading_remove').html('<span>Adding Article</span>').fadeIn('fast');
			},

			complete: function() {
				jQuery('#wp_emaily_loading').fadeOut('fast');
			},

			success: function(txt) {
				jQuery('#wp_emaily_selected_articles').html(txt);
				jQuery(a).parent().remove();
				wpEmaily.createInput(a.rel);
			},

			error: function() {
			//called when there is an error
			}
		});
		
		return false;
		
	};
	
	wpEmaily.remove = function (a) {
		jQuery.ajax({
			url: a.href+'&ajax=true&action=remove',
			type: 'GET',

			beforeSend: function() {
				jQuery('#wp_emaily_loading').addClass('wp_emaily_loading_remove').html('<span>Removing Article</span>').fadeIn('fast');
			},

			complete: function() {
				jQuery('#wp_emaily_loading').fadeOut('fast');
			},

			success: function(txt) {
				jQuery('#wp_emaily_selected_articles').html(txt);
				jQuery('#wp_emaily_available_articles').load(a.href+'&ajax=true&action=available');
				jQuery(a).parent().remove();
				jQuery('input#post-'+a.rel).remove();
			},

			error: function() {
			//called when there is an error
			}
		});
	}
	
	wpEmaily.addAdvert = function (a) {
		var linkValue = escape(jQuery('#wp_emaily_advert_link').val());
		var imageValue = escape(jQuery('#wp_emaily_advert_image').val());
		jQuery.ajax({
			url: a.href+'?ajax=true&action=add_advert',
			type: 'GET',
			data: "wp_emaily_advert_image="+imageValue+ "&wp_emaily_advert_link="+linkValue,
			
			beforeSend: function() {
				jQuery('#wp_emaily_loading2').removeClass('wp_emaily_loading_remove').html('<span>Adding Advert</span>').fadeIn('fast');
			},

			complete: function() {
				jQuery('#wp_emaily_loading2').fadeOut('fast');
			},

			success: function(txt) {
				jQuery('#wp_emaily_current_adverts').html(txt);
				/*if (imageValue.match(/\.jpg$|\.jpeg$/gi)) {
					jQuery('div#wp_emaily form').append('<input type="hidden" name="adverts['+linkValue+'][link]" value="'+linkValue+'" id="link-'+linkValue+'">');
					jQuery('div#wp_emaily form').append('<input type="hidden" name="adverts['+linkValue+'][image]" value="'+imageValue+'" id="image-'+linkValue+'">');
				}*/
			},

			error: function() {
			//called when there is an error
			}
		});
		
		return false;
		
	};
	
	wpEmaily.removeAdvert = function (a) {
		jQuery.ajax({
			url: a.href+'?ajax=true&action=remove_advert&wp_emaily_advert_link='+a.rel,
			type: 'GET',

			beforeSend: function() {
				jQuery('#wp_emaily_loading2').addClass('wp_emaily_loading_remove').html('<span>Removing Advert</span>').fadeIn('fast');
			},

			complete: function() {
				jQuery('#wp_emaily_loading2').fadeOut('fast');
			},

			success: function(txt) {
				jQuery('#wp_emaily_current_adverts').html(txt);
				jQuery(a).parent().remove();
				jQuery('input#image-'+a.rel).remove();
				jQuery('input#link-'+a.rel).remove();
			},

			error: function() {
			//called when there is an error
			}
		});
	}
	
	wpEmaily.createInput = function (id) {
		jQuery('div#wp_emaily form').append('<input type="hidden" name="posts[]" value="'+id+'" id="post-'+id+'">');
	};
	
</script>