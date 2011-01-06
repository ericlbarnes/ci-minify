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
 * Minify Driver
 *
 * @subpackage	Drivers
 */
class Minify extends CI_Driver_Library {

	protected $_ci = '';

	/**
	 * valid drivers
	 *
	 * @var array
	 */
	public $valid_drivers = array('minify_css', 'minify_js');

	// ------------------------------------------------------------------------

	/**
	 * Construct
	 *
	 * Initialize params
	 *
	 * @param	array
	 * @return 	void
	 */
	public function __construct($params = array())
	{
		$this->_ci =& get_instance();
	}

	// ------------------------------------------------------------------------

	/**
	 * Combine Files
	 *
	 * Pass an array of files and combine them.
	 *
	 * @param	array $files
	 * @param	string $type
	 * @return 	void
	 */
	public function combine_files($files = array(), $type = '')
	{
		if ( ! is_array($files) OR count($files) < 1)
		{
			log_message('error', 'Minify->combine_files missing files array');
			return FALSE;
		}

		$contents = '';

		foreach ($files AS $file)
		{
			if ($type == '')
			{
				$type = $this->_get_type($file);
			}

			$contents .= '// '.pathinfo($file, PATHINFO_BASENAME)."\n";

			if ($type == 'css')
			{
				$contents .= $this->css->min($file)."\n\n";
			}
			elseif ($type == 'js')
			{
				$contents .= $this->js->min($file)."\n\n";
			}
			else
			{
				$contents .= $file."\n\n";
			}
		}

		return $contents;
	}

	// ------------------------------------------------------------------------

	/**
	 * Combine Directory
	 *
	 * Pass a directory and combine all the files into one string.
	 *
	 * @param	string $directory
	 * @param	array $ignore
	 * @return 	string
	 */
	public function combine_directory($directory = '', $ignore = array(), $type = '')
	{
		$available = array();

		if ($directory == '' OR ! is_dir($directory))
		{
			log_message('error', 'Minify->combine_directory missing files array');
			return FALSE;
		}

		$this->_ci->load->helper('directory');
		foreach (directory_map($directory, TRUE) as $dir => $file)
		{
			if ($this->_get_type($file) == 'js' OR $this->_get_type($file) == 'css')
			{
				$available[$file] = $directory.'/'.$file;
			}
		}

		// Finally get ignored files
		if (count($ignore) > 0)
		{
			foreach ($available AS $key => $file)
			{
				if (in_array($key, $ignore))
				{
					unset($available[$key]);
				}
			}
		}

		return $this->_do_combine($available, $type);
	}

	// ------------------------------------------------------------------------

	/**
	 * Do combine
	 *
	 * Combine all the files and return a string.
	 *
	 * @param	array $files
	 * @param	string $type
	 * @return 	string
	 */
	private function _do_combine($files, $type)
	{
		$contents = '';

		foreach ($files as $file)
		{
			if ( ! file_exists($file))
			{
				continue;
			}

			$contents .= '// '.pathinfo($file, PATHINFO_BASENAME)."\n";

			if ($type == '')
			{
				$type = $this->_get_type($file);
			}

			if ($type == 'css')
			{
				$contents .= $this->css->min($file)."\n\n";
			}
			elseif ($type == 'js')
			{
				$contents .= $this->js->min($file)."\n\n";
			}
			else
			{
				$contents .= $data."\n\n";
			}
		}

		return $contents;
	}

	// ------------------------------------------------------------------------

	/**
	 * Save File
	 *
	 * Save a file
	 *
	 * @param	string $contents
	 * @param	string $full_path
	 * @return 	bool
	 */
	public function save_file($contents = '', $full_path = '')
	{
		$this->_ci->load->helper('file');

		if ( ! write_file($full_path, $contents))
		{
			log_message('error', 'Minify->save_file could not write file');
			return FALSE;
		}
		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Type
	 *
	 * Get the file extension to determine file type
	 *
	 * @param	string $file
	 * @return 	string
	 */
	private function _get_type($file)
	{
		return pathinfo($file, PATHINFO_EXTENSION);
	}
}

/* End of file Minify.php */
/* Location: ./application/libraries/Minify/Minify.php */