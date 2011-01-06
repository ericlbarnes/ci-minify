<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Minify
 *
 * @package		ci-minify
 * @author		Eric Barnes
 * @copyright	Copyright (c) Eric Barnes
 * @since		Version 1.0
 * @link 		https://github.com/ericbarnes/ci-minify
 */

// ------------------------------------------------------------------------

/**
 * Example Controller
 *
 * @subpackage	Controllers
 */
class Example extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->driver('minify');
	}

	function index()
	{
		$file = 'test/js/colorbox.js';
		echo $this->minify->js->min($file);
	}

	public function combine()
	{
		echo $this->minify->combine_directory('test/css');
	}
}

/* End of file example.php */
/* Location: ./application/controllers/example.php */