<article class="single_post">
	
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td align="left">
				<h2 style="text-align:left;"><?php echo $post->title; ?></h2>
			</td>
			<td align="right">
				<span style="font-size: 10px;text-align:right;">
						Posted: <?php echo format_date($post->created_on); ?>
				</span>
			<td>
		</tr>
		<tr><td colspan="2"><hr></td></tr>
	</table>
	
	<div class="post_body">
		<?php echo $post->body; ?>
	</div>
			
	<div class="post_meta">
		<?php if($post->keywords) : ?>
			{{ theme:image file="tags.png" }}
			<span class="tags">
				<?php echo $post->keywords; ?>
			</span>
		<?php endif; ?>
	</div>			
</article>