<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Savepdf extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'SavePDF'
			),
			'description' => array(
				'en' => 'Library that allows your to save pages and blogs as PDF.'
			),
			'author' => 'Ryun Shofner',
			'frontend' => FALSE,
			'backend' => FALSE
		);
	}

	public function install()
	{
            return TRUE;
	}

	public function uninstall()
	{
            return TRUE;
	}

	public function upgrade($old_version)
	{
		return TRUE;
	}

	public function help()
	{
		return "For documentation visit: http://humboldtweb.com/docs/savepdf";
	}
}
/* End of file details.php */
