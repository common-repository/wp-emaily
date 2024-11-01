<style type="text/css" media="screen">
	th#date {
		width: 100px;
	}
	th#author {
		width: 200px;
	}
</style>

<div id="wp_emaily" class="wrap">
<form action="" method="post">
	<h2>WP Emaily v<?php echo WPEmaily::getVersion(); ?></h2>
	
	<p>Created emails - filtering options coming soon.</p>

	<!--div class="tablenav">
		
	<?php $page_links = WPEmaily::paginate_links( array(
			'base' => add_query_arg( 'paged', '%#%' ),
			'format' => '',
			'total' => $wp_query->max_num_pages,
			'current' => $_GET['paged']
		));
	?>

	<?php if ($page_links): ?>
	<div class='tablenav-pages'>
		<?=$page_links?>
		<span class='page-numbers current'>1</span>
				<a class='page-numbers' href='<?php bloginfo('siteurl') ?>/wp-emaily.php?paged=2'>2</a>
				<a class='page-numbers' href='/portfolio/drummondclinic/wp/wp-admin/edit.php?paged=3'>3</a>
				<span class='page-numbers dots'>...</span>
				<a class='page-numbers' href='/portfolio/drummondclinic/wp/wp-admin/edit.php?paged=5'>5</a>

				<a class='next page-numbers' href='/portfolio/drummondclinic/wp/wp-admin/edit.php?paged=2'>Next &raquo;</a>
	</div>
	<?php endif ?>
	
	
	<div class="alignleft">
	<input type="submit" value="Delete" name="deleteit" class="button-secondary delete" />
	<input type="hidden" id="_wpnonce" name="_wpnonce" value="4d309c8932" /><input type="hidden" name="_wp_http_referer" value="/portfolio/drummondclinic/wp/wp-admin/edit.php" /><select name='m'>
	<option selected="selected" value='0'>Show all dates</option>
		<option value='200901'>January 2009</option>
		<option value='200812'>December 2008</option>
		<option value='200811'>November 2008</option>
		<option value='200810'>October 2008</option>
		<option value='200808'>August 2008</option>

		<option value='200807'>July 2008</option>
	</select>

	<input type="submit" id="post-query-submit" value="Filter" class="button-secondary" />

	<br class="clear" />
	</div>

	<br class="clear" />
	
	</div-->
	
	<?php $emails = WPEmaily::getEmails(); ?>
	
	<table class="widefat">
		<thead>
		<tr>

		<th scope="col" class="check-column"><input type="checkbox" /></th>
		<th scope="col" id="date">Date</th>

		<th scope="col" id="title">Title</th>
		<th scope="col" id="author">Author</th>
		</tr>
		</thead>
		
		<?php if (count($emails['emails']) > 0): ?>
		<tbody>


		<?php foreach ($emails['emails'] as $key => $email): $count++; ?>
		<?php
			if ($count % 2) {
				$row = 'alternate';
			} else {
				$row = '';
			}
		?>
		<tr id='post-<?php echo $email->id ?>' class='<?php echo $row ?> author-self status-publish' valign="top">

			<th scope="row" class="check-column"><input type="checkbox" name="delete[]" value="923" /></th>
					<td><abbr title="<?php echo $email->date_created ?>"><?php echo WPEmaily::dateConvert('Y/m/d', $email->date_created) ?></abbr></td>
					<td><strong><a class="row-title" href="<?php echo WPEMAILY_URL ?>/wp-emaily-zip-creation.php?filename=<?php echo $email->filename ?>" title="Download ZIP of &quot;<?php echo $email->title ?>&quot;"><?php echo $email->title ?></a></strong>
			</td>
			<?php $author = get_userdata($email->author); ?>
			<td><a href="edit.php?author=<?php echo $author->ID; ?>"><?php echo $author->user_login; ?></a></td>
		</tr>
		<?php endforeach ?>

		</tbody>
		<?php else : ?>
			<tbody>

			<tr class='<?php echo $row ?> author-self status-publish' valign="top">
				<td colspan="4">
					<p>No emails have been created. <a href="admin.php?page=create-email">Create an email</a></p>
				</td>
			</tr>

			</tbody>
			
		<?php endif ?>
	</table>

</form><!-- form closes -->
</div>
<script type="text/javascript" charset="utf-8">
	jQuery('thead th.check-column input').get(0).onchange = function() {
		if (this.checked == true) {
			jQuery('tbody th.check-column input').attr('checked', 'checked');
		} else {
			jQuery('tbody th.check-column input').removeAttr('checked');
		}
	}
</script>