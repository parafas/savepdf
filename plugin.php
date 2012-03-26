<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * SavePDF Plugin
 *
 * Create links
 *
 * @author		Ryun Shofner
 */
class Plugin_Savepdf extends Plugin
{
	/**
	 * Generate Page link for PDF export
	 *
	 * @return string
	 */
	public function page_link()
	{
		return '<a href="'.site_url('savepdf').'?page='.$this->uri->uri_string().'">Save PDF</a>';
	}

	/**
	 * Generate Blog link for PDF export
	 *
	 * @return string
	 */	 
	public function blog_link()
	{
		return '<a href="'.site_url('savepdf').'?blog='.$this->uri->segment(4, 0).'">Save PDF</a>';
	}
}

/* End of file plugin.php */