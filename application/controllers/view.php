<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class View extends CI_Controller {
  //var $base;
  //var $css;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
  $this->load->library('javascript');
  $this->load->library('session');
		//$this->load->library('jquery');
   #Getting the properties from the config file
   //$this->base = $this->config->item('base_url');
   //$this->css = $this->config->item('css');
	}

}//end of the controller


/* End of file login.php */
/* Location: ./application/controllers/login.php */
