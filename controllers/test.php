<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Minify
 *
 * @package ci-minify
 * @author Eric Barnes
 * @copyright Copyright (c) Eric Barnes
 * @since Version 1.0
 * @link http://ericlbarnes.com
 */

// ------------------------------------------------------------------------

/**
 * Unit Test Controller
 *
 * @subpackage	Controllers
 */
class Test extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->driver('minify');
	}

	function index()
	{
		$class_methods = get_class_methods($this);
		foreach ($class_methods as $method_name)
		{
			if (substr($method_name, 0, 5) == '_test')
			{
				self::$method_name();
			}
		}

		echo $this->unit->report();
	}

	private function _test_css()
	{
		$file = 'test/css/calendar.css';
		$this->unit->run($this->minify->css->min($file), 'is_string', 'test min css');
	}

	private function _test_js_min()
	{
		$file = 'test/js/colorbox.js';
		$this->unit->run($this->minify->js->min($file), 'is_string', 'test min js');
	}
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */