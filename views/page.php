<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
<style type="text/css">
body {
font-family: helvetica;
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
					<?php $dt = ($page->updated_on) ? $page->updated_on : $page->created_on; echo format_date($dt); ?>
				</td>
				<td align="right">
					<?php echo site_url($page->uri); ?>
				<td>
			</tr>
		</table>
	</div>
	<article class="page">
		<h2><?php echo $page->title; ?></h2>
		<hr>
		<?php echo $page->body; ?>
	</article>
</body>
</html>