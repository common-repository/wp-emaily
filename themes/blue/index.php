<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title><?php echo $title ?></title>
</head>
<body>

<style type="text/css" media="screen">
	body {
		background: #04b0db;
	}
	table.container {
		font-size: 0px;
	}
	.h1 {
		font-size: 18px;
		font-weight: bold;
	}
	.p {
		font-family: Arial, "MS Trebuchet", sans-serif;
	}
	.footer .p {
		color: #fff;
		font-size: 11px;
	}
	.header .p {
		color: #fff;
		font-size: 11px;
	}
	.promotions .p {
		font-size: 15px;
	}
	.emailLink {
		color: #0673a5;
		text-decoration: underline;
	}
	.header .emailLink {
		color: #fff;
	}
	.footer .emailLink {
		color: #fff;
	}
	.promotionsBorderLeft {
		border-left: 1px solid #ccc;
	}
	.promotionsBorderRight {
		border-right: 1px solid #ccc;
	}
	.article {
		border-bottom: 1px solid #ccc;
	}
	.lastArticle {
		border-bottom: 0px solid !important;
	}
	.article .h2 .emailLink {
		text-decoration: none;
	}
	.article .emailDate {
		color: #999;
	}
</style>

<div style="display:none;">
	<!-- For Outlook preview -->
	<img src="<?php echo $url ?>/spacer.gif" alt="<?php echo $outlookPreview ?>" width="1" height="1">
	<!-- For Outlook preview -->
</div>
<table class="container" width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#04b0db">
	
	<tr>
		<td align="center">
			<table border="0" cellspacing="0" cellpadding="0" width="550" class="header">
				<tr>
					<td align="center">
						<font face="arial" color="#ffffff" size="1" class="p">If this email isn't looking right, <a href="<?php echo $emailLink ?>" class="emailLink">view it in a browser</a>.</font>
					</td>
				</tr>
				
				<!-- Spacer -->
				<tr>
					<td class="padding" colspan="2" height="18"><img src="<?php echo $url ?>/spacer.gif" alt=" " height="18"></td>
				</tr>
				<!-- Spacer -->
				
				<tr>
					<td valign="top" align="center">
						<img src="<?php echo $url ?>/logo.gif" alt="Logo" width="253" height="60" />
					</td>
				</tr>
				
				<!-- Spacer -->
				<tr>
					<td class="padding" colspan="2" height="10"><img src="<?php echo $url ?>/spacer.gif" alt=" " height="10"></td>
				</tr>
				<!-- Spacer -->
			</table>
		</td>
	</tr>
	
	
   <tr>
      <td align="center">
         
         <table border="0" cellspacing="0" cellpadding="0" width="550" bgcolor="#ffffff">
	
			<tr>
				<td colspan="5">
					<img src="<?php echo $url ?>/header.gif" width="550" height="9" style="padding:0;margin:0;" alt=" ">
				</td>
			</tr>
	
         	<tr>
				<td class="column-1 padding" width="10">&nbsp;</td>
         		<td class="column-2" width="310" align="left" valign="top">
					
					<div style="margin-bottom:12px;">
						<font face="arial" size="3" class="h1"><b><?php echo $title ?></b></font>
					</div>

         			<?php foreach ($articles as $post): setup_postdata($post); $count++; ?>
					<?php if ($count == count($articles)){
						$articleClass = 'article lastArticle';
					} else {
						$articleClass = 'article';
					}?>

         				<table border="0" cellspacing="0" cellpadding="0" class="<?php echo $articleClass ?>">
	
							<?php if ($post->image): ?>
							<tr>
	        					<td class="image">
	        						<?php echo wp_get_attachment_image($post->image['ID'], 'large') ?>
	        					</td>
	        				</tr>
							<?php endif ?>
							
							<!-- Spacer -->
							<tr>
								<td class="padding" height="10" width="100%"><img src="<?php echo $url ?>/spacer.gif" alt=" " height="10" width="100%"></td>
							</tr>
							<!-- Spacer -->
							
        					<tr>
        						<td class="text" width="310">
        							<div style="margin-bottom:8px;">
        								<font face="arial" size="3" class="h2"><a href="<?php the_permalink() ?>" class="emailLink"><b><?php the_title() ?></b></a></font>
        							</div>
								<div>
									<font face="arial" size="2" class="p"><?php echo get_the_excerpt() ?> <a href="<?php the_permalink() ?>" class="emailLink">Read more</a></font>
								</div>
								<div>
									<font face="arial" size="2" class="p emailDate"><i><?php the_time('d F Y') ?></i></font>
								</div>
        						</td>
        					</tr>

							<!-- Spacer -->
							<tr>
								<td class="padding" height="14"><img src="<?php echo $url ?>/spacer.gif" alt=" " height="14"></td>
							</tr>
							<!-- Spacer -->
							
	        			</table>
         			<?php endforeach ?>
					
					<img src="<?php echo $url ?>/spacer.gif" alt=" " height="12" width="100%" class="br">

         		</td>
				<td class="column-3 padding" width="20">&nbsp;</td>
         		<td class="column-4" width="200" align="left" valign="top">
					
					<?php if ($promotion): ?>
						<table border="0" cellspacing="0" cellpadding="0" class="promotions" width="200">
							<tr>
								<td valign="bottom" align="left" colspan="3">
									<img src="<?php echo $url ?>/promotion-header.gif" width="200" height="169" alt="Promotion Header">
								</td>
							</tr>
							<tr valign="top">
								<td width="8" valign="top" bgcolor="#ededed" class="promotionsBorderLeft" align="left">&nbsp;</td>
								<td valign="top" align="left" bgcolor="#ededed" width="184">
									<font face="arial" size="2" class="p"><b><?php echo $promotion ?></b></font>
								</td>
								<td width="8" valign="top" bgcolor="#ededed" class="promotionsBorderRight" align="right">&nbsp;</td>
							</tr>
							<tr>
								<td valign="top" align="left" colspan="3">
									<img src="<?php echo $url ?>/promotion-footer.gif" width="200" height="14" alt="Promotion Footer">
								</td>
							</tr>
						</table>
					<?php endif ?>
					
					<?php if (count($adverts) > 0): ?>
						<img src="<?php echo $url ?>/spacer.gif" alt=" " height="8">
						<table>
							<tr>
								<td align="center" width="200">
									<font face="arial" size="1" color="#999999">Adverts</font>
								</td>
							</tr>
							<tr>
								<?php foreach ($adverts as $advert): ?>
								<td width="200" align="center">
									<a href="<?php echo $advert['link'] ?>"><img alt="Advert" width="180" height="150" src="<?php echo $advert['image'] ?>" border="0" /></a>
								</td>
								<!-- Spacer -->
								<tr>
									<td class="padding" height="18"><img src="<?php echo $url ?>/spacer.gif" alt=" " height="18"></td>
								</tr>
								<!-- Spacer -->
								<?php endforeach ?>
							</tr>
						</table>
					<?php endif ?>

         		</td>
				<td class="column-3 padding" width="10">&nbsp;</td>
         	</tr>

         </table>
		<img src="<?php echo $url ?>/footer.gif" width="550" height="9" style="padding:0;margin:0;" alt=" ">
         
      </td>
   </tr>


	<tr>
		<td align="center">
			<table border="0" cellspacing="0" cellpadding="0" width="550" class="footer">
				<!-- Spacer -->
				<tr>
					<td class="padding" colspan="2" height="10">&nbsp;</td>
				</tr>
				<!-- Spacer -->
				<tr>
					<td width="260" align="left" valign="top">
						<font face="arial" color="#ffffff" size="1" class="p">&copy; Your Company 2008</font>
					</td>
					<td align="left" valign="top">
						<font face="arial" color="#ffffff" size="1" class="p">If you would prefer not to receive news, <a href="#" class="emailLink">click here to unsubscribe</a>.</font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>