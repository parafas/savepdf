<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * SavePDF admin controller
 *
 */
class Admin extends Admin_Controller {

	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'savepdf';

	public function __construct()
	{
		parent::__construct();
	}
}