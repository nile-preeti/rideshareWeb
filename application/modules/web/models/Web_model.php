<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * 

 */

class Web_model extends MY_Model
{
	function __construct()
	{
		$this->load->database();
	}
}