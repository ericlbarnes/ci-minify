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
 * Minify CSS Driver
 *
 * @subpackage	Drivers
 */
class Minify_css extends CI_Driver {

	public function __construct()
	{
		log_message('debug', 'Minify CSS Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Min
	 *
	 * Minify a js file
	 *
	 * @param	string $file
	 * @return 	string
	 */
	public function min($file = '')
	{
		if ($file == '' OR ! file_exists($file))
		{
			log_message('error', 'Minify_css->min missing file');
			return FALSE;
		}

		return $this->_compress(file_get_contents($file));
	}

	// ------------------------------------------------------------------------

	/**
	 * Compress
	 *
	 * Compress the contents of a css file
	 *
	 * @param	string $contents
	 * @return 	string
	 */
	private function _compress($contents)
	{
		// remove comments
		$contents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $contents);
		// remove tabs, spaces, newlines, etc.
		$contents = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $contents);
		return $contents;
	}
}

/* End of file Minify_css.php */
/* Location: ./application/libraries/Minify/drivers/Minify_css.php */