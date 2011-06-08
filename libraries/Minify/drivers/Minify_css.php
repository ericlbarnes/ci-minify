<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Minify
 *
 * @package ci-minify
 * @author Eric Barnes, F.S. Encinas
 * @copyright Copyright (c) Eric Barnes
 * @since Version 1.0
 * @link http://ericlbarnes.com
 * @link https://github.com/fsencinas/ci-minify/
 */

// ------------------------------------------------------------------------

/**
 * Minify CSS Driver
 *
 * @subpackage	Drivers
 */
class Minify_css extends CI_Driver {

	/**
	 * Constructor
	 *
	 * @return \Minify_css
	 */
	public function __construct()
	{
		log_message('debug', 'Minify CSS Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Min
	 *
	 * Minify a CSS file
	 *
	 * @param string $file
	 * @param bool $compact
	 * @param null $is_aggregated
	 * @return string
	 */
	public function min($file = '', $compact = TRUE, $is_aggregated = NULL)
	{
		if ($file == '' OR ! file_exists($file))
		{
			log_message('error', 'Minify_css->min missing file '.$file);
			return FALSE;
		}

		if ( ! isset($is_aggregated))
		{
			$contents = file_get_contents($file);
		}
		else
		{
			$contents = $this->remove_charsets(file_get_contents($file));
		}

		if ($compact != FALSE)
		{
			return trim($this->_optimize($contents))."\n";
		}
		else
		{
			return "\n".trim($contents)."\n\n";
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Remove charsets
	 *
	 * Charset declarations removal to support do combine function
	 * in order to set a new one user defined charset at the beggining of the document
	 * to keep standars compliance (and fix Webkit buggy behaviours)
	 *
	 * @author F.S.Encinas
	 * @param string $contents
	 * @return string
	 */
	private function remove_charsets($contents)
	{
		return preg_replace('/^@charset\s+[\'"](\S*)\b[\'"];/i', '', $contents);
	}

	// ------------------------------------------------------------------------

	/**
	 * Optimize
	 * Optimize the contents of a css file
	 * based on Drupal 7 CSS Core aggregator
	 *
	 * @author F.S.Encinas
	 * @param string $contents
	 * @return string
	 */
	private function _optimize($contents)
	{
		// Perform some safe CSS optimizations.
		// Regexp to match comment blocks.
		$comment     = '/\*[^*]*\*+(?:[^/*][^*]*\*+)*/';
		// Regexp to match double quoted strings.
		$double_quot = '"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"';
		// Regexp to match single quoted strings.
		$single_quot = "'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'";
		// Strip all comment blocks, but keep double/single quoted strings.
		$contents = preg_replace(
			"<($double_quot|$single_quot)|$comment>Ss",
			"$1",
			$contents
		);
		// Remove certain whitespace.
		// There are different conditions for removing leading and trailing
		// whitespace.
		// @see http://php.net/manual/en/regexp.reference.subpatterns.php
		$contents = preg_replace_callback(
			'<' .
			# Strip leading and trailing whitespace.
			'\s*([@{};,])\s*' .
			# Strip only leading whitespace from:
			# - Closing parenthesis: Retain "@media (bar) and foo".
			'| \s+([\)])' .
			# Strip only trailing whitespace from:
			# - Opening parenthesis: Retain "@media (bar) and foo".
			# - Colon: Retain :pseudo-selectors.
			'| ([\(:])\s+' .
			'>xS',
			array(get_class($this), '_optimize_call_back'),
			$contents
		);

		return $contents;
	}

	/**
	 * Optimize CB
	 * Optimize Callback Helper companion for optimize fn
	 * based on Drupal 7 CSS Core aggregator
	 *
	 * @author F.S.Encinas
	 * @param string $matches
	 * @return array
	 */
	private function _optimize_call_back($matches)
	{
		// Discard the full match.
		unset($matches[0]);

		// Use the non-empty match.
		return current(array_filter($matches));
	}
}

/* End of file Minify_css.php */
/* Location: ./application/libraries/Minify/drivers/Minify_css.php */