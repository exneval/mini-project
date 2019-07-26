<?php

include_once 'ReqInterface.php';

/**
 * Article Source: https://medium.com/the-andela-way/how-to-build-a-basic-server-side-routing-system-in-php-e52e613cf241
 * Gist Source: https://gist.github.com/john555/62001aca8d24e13714e1d29decdd57e0
 * @author: john555
 */
class Request implements ReqInterface {

	function __construct() {
		$this->bootstrapSelf();
	}

	/**
	 * Sets all keys in the global $_SERVER array
	 * as properties of the Request class and assigns their values as well
	 */
	private function bootstrapSelf() {
		foreach ($_SERVER as $key => $value) {
			$this->{$this->toCamelCase($key)} = $value;
		}
	}

	/**
	 * Converts a string from snake case to camel case
	 */
	private function toCamelCase($string) {
		$result = strtolower($string);
		preg_match_all('/_[a-z]/', $result, $matches);
		foreach ($matches[0] as $match) {
			$c = str_replace('_', '', strtoupper($match));
			$result = str_replace($match, $c, $result);
		}
		return $result;
	}

	/**
	 * Implementation of the method defined in the RequestInterface
	 */
	public function getBody() {
		if ($this->requestMethod === 'GET') {
			return;
		}
		if ($this->requestMethod === 'POST') {
			$body = array();
			foreach($_POST as $key => $value) {
				$body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			return $body;
		}
	}

	/**
	 * Add getParams function
	 * @author: exneval
	 */
	public function getParams() {
		if ($this->requestMethod === 'GET') {
			$params = array();
			foreach($_GET as $key => $value) {
				$params[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			return $params;
		}
		if ($this->requestMethod === 'POST') {
			return;
		}
	}
}

?>
