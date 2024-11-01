<?php if ($message): ?>
	<div id="message" class="updated fade">
		<p><?php echo $message ?></p>
	</div>
<?php endif ?>
<?php include('css.php') ?>
<div id="wp_emaily" class="wrap">
<form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
	
	<h2>Settings</h2>
	
	<h3>Email Category</h3>
	<legend></legend>
	<p>This categories will be used for selecting articles.</p>
	<ul>
		<?php wp_category_checklist(0, 0, $categories); ?>
	</ul>
	
	<hr />
	
	<h3>Article limit</h3>
	<p>The number of articles to be displayed.</p>
	<p>
		<label for="wp_emaily_article_limit">
			<input type="text" name="wp_emaily_article_limit" id="wp_emaily_article_limit" size="3" maxlength="3" value="<?php echo $article_limit ?>" /> articles
		</label>
	</p>
	
	<hr />
	
	<h3>Word limit</h3>
	<p>The limit of words to be displayed for each article.</p>
	<p>
		<label for="wp_emaily_word_limit">
			<input type="text" name="wp_emaily_word_limit" id="wp_emaily_word_limit" size="3" maxlength="3" value="<?php echo $word_limit ?>" /> words
		</label>
	</p>
	
	<hr class="end" />
	<p>
		<input type="submit" class="button" value="Save settings">
	</p>
</form>
</div>