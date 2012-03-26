<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size: 10px;">
	<tr>
		<td align="left">
			<?php $dt = ($page->updated_on) ? $page->updated_on : $page->created_on; echo format_date($dt); ?>
		</td>
		<td align="right">
			Address: <?php echo site_url($page->uri); ?>
		<td>
	</tr>
	<tr><td colspan="2"><hr></td></tr>
</table>

<article class="page">
	<h2><?php echo $page->title; ?></h2>
	<hr>
	<?php echo $page->body; ?>
</article>