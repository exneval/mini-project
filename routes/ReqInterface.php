<?php

/**
 * Article Source: https://medium.com/the-andela-way/how-to-build-a-basic-server-side-routing-system-in-php-e52e613cf241
 * Gist Source: https://gist.github.com/john555/c3143e01e78f7729af3676228802de8d
 * @author: john555
 */
interface ReqInterface {

	public function getBody(); //Retrieves data from the request body

	/**
	 * Add getParams function
	 * @author: exneval
	 */
	public function getParams(); //Retrieves data from GET request
}

?>
