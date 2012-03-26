<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("dompdf_config.inc.php");

class savepdf_lib {
	
	public $dompdf = NULL;

	public function __construct()
	{
		$this->dompdf = new DOMPDF();
	}
	
	public function load($html,$name)
	{
		if (!$name) $name = md5(time());
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream(str_replace(' ', '_', $name).'.pdf');
	}
}
