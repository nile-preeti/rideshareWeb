<?php







defined('BASEPATH') OR exit('No direct script access allowed') ;







class Template extends MY_Controller
{

	function __construct()

	{

		parent::__construct();

	}







	/* Load site Template */

	public function site_template($data)
	{

		$this->load->view('site_index',$data);

	}

	/* Load admin Template */

	public function admin_template($data)

	{

		$this->load->view('admin-template',$data);

	}



	/* Load user Template */



	


	public function driver_template($data)

	{

		$this->load->view('driver_template',$data);
	}

	public function rider_template($data)

	{

		$this->load->view('rider_template',$data);
	}


	/* Load admin Template */



	public function login_template($data)



	{



		$this->load->view('admin_login_template',$data);



	}







	/* Load user dashboard template */



	public function user_dashboard_template($data)



	{



		$this->load->view('dashboard_index',$data);



	}

	/* web view template */

	public function web_template($data)

	{
		$this->load->view('web_index',$data);
	}
	
	/* App view template */

	public function app_template($data)

	{
		$this->load->view('app_index',$data);
	}
	
	public function authorized_template($data)

	{
		$this->load->view('app_index',$data);
	}







}







