<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
<style type="text/css">

body {
  padding: 0;
  margin: 1em 0 0 0;
}


div.header,
div.footer {
  position: fixed;
  width: 100%;
  overflow:hidden;
}

div.header {
  top: 0cm;
  border-bottom-width: 1px;
  height: 3em;
}

div.footer {
  bottom: 0cm;
  border-top-width: 1px;
  height: 1em;
}

div.footer table {
  width: 100%;
  text-align: center;
}
.small {font-size: 10px;}
hr {padding:0;margin:0;}
h2 {margin-bottom:.3em;padding-bottom:0;}
</style>

</head>

<body>

<div class="header">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="small">
		<tr>
			<td align="left">
				<?php echo $post->title; ?>
			</td>
			<td align="right">
				<span style="font-size: 10px;text-align:right;">
						<?php echo $post->url; ?>
				</span>
			<td>
		</tr>
	</table>
</div>

<article class="single_post">
	<h2 style="text-align:left;"><?php echo $post->title; ?></h2>
	<hr>
	<span class="small">Posted at <b><?php echo format_date($post->created_on); ?></b> <?php echo ($post->category->title) ? 'in <b>'.$post->category->title.'</b>':''; ?></span>
	<div class="post_body">
		<?php echo $post->body; ?>
	</div>
</article>

</body>

</html>