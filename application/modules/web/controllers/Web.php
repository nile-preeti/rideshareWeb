<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**

 * 

*/
class Web extends MY_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->model('Web_model');
		$this->load->library(array('common/Tables','pagination'));
		$this->load->helper(array('common/common','url'));
        $this->config->load('config');
	}
    public function index(){
        return redirect('http://ridesharerates.com/admin');
    }
    public function index_old()
    {
        //$data['css_array']       = $this->config->config['rider_css'];

        //$data['js_array']        = $this->config->config['Home_js'];

		$data['title'] 			 ='Home '.SITE_TITLE;

		$data['keyword'] 		 ='Home '.SITE_TITLE;

		$data['description'] 	 ='Home '.SITE_TITLE;

		$data['content']		 ='web/index';

		echo Modules::run('template/web_template',$data);
    }
    public function riders(Type $var = null)
    {
        $data['css_array']       = $this->config->config['rider_css'];
        $data['title'] 			 ='Riders '.SITE_TITLE;
		$data['keyword'] 		 ='Riders '.SITE_TITLE;
		$data['description'] 	 ='Riders '.SITE_TITLE;
		$data['content']		 ='web/rider';
		echo Modules::run('template/web_template',$data);
    }
    /* drivers */
    public function drivers()
    {
        $data['css_array']       = $this->config->config['rider_css'];
        $data['title'] 			 ='Drivers '.SITE_TITLE;
		$data['keyword'] 		 ='Drivers '.SITE_TITLE;
		$data['description'] 	 ='Drivers '.SITE_TITLE;
		$data['content']		 ='web/driver';
		echo Modules::run('template/web_template',$data);# code...
    }
    /* about us */
    public function about_us()
    {
        $data['css_array']       = $this->config->config['rider_css'];
        $data['title'] 			 ='About us '.SITE_TITLE;
		$data['keyword'] 		 ='About Us '.SITE_TITLE;
		$data['description'] 	 ='About Us '.SITE_TITLE;
		$data['content']		 ='web/about_us';
		echo Modules::run('template/web_template',$data);
    }
	public function app_about_us()
    {
        
        $data['css_array']       = $this->config->config['rider_css'];
        $data['title'] 			 ='About us '.SITE_TITLE;
		$data['keyword'] 		 ='About Us '.SITE_TITLE;
		$data['description'] 	 ='About Us '.SITE_TITLE;
		$data['content']		 ='web/app-about-us';
		echo Modules::run('template/app_template',$data);
    }
    public function faq()
    {
        $data['css_array']       = $this->config->config['faq_css'];
        $data['title'] 			 ='FAQ '.SITE_TITLE;
		$data['keyword'] 		 ='FAQ '.SITE_TITLE;
		$data['description'] 	 ='FAQ '.SITE_TITLE;
		$data['content']		 ='web/faq';
		echo Modules::run('template/web_template',$data);
    }
    public function contact_us()
    {
        $data['css_array']       = $this->config->config['faq_css'];
        $data['title'] 			 ='Contact Us '.SITE_TITLE;
		$data['keyword'] 		 ='Contact Us '.SITE_TITLE;
		$data['description'] 	 ='Contact Us '.SITE_TITLE;
		$data['content']		 ='web/contact_us';
		echo Modules::run('template/web_template',$data);
    }
	
	public function app_contact_us()
    {
        $data['css_array']       = $this->config->config['faq_css'];
        $data['title'] 			 ='Contact Us '.SITE_TITLE;
		$data['keyword'] 		 ='Contact Us '.SITE_TITLE;
		$data['description'] 	 ='Contact Us '.SITE_TITLE;
		$data['content']		 ='web/app_contact_us';
		echo Modules::run('template/app_template',$data);
    }
    public function privacy_policy()
    {
        $data['css_array']       = $this->config->config['insurence_css'];
        $data['title'] 			 ='Privacy Policy '.SITE_TITLE;
		$data['keyword'] 		 ='Privacy Policy '.SITE_TITLE;
		$data['description'] 	 ='Privacy Policy '.SITE_TITLE;
		$data['content']		 ='web/privacy_policy';
		echo Modules::run('template/web_template',$data);
    }
    
    public function app_privacy_policy()
    {
        $data['css_array']       = $this->config->config['insurence_css'];
        $data['title'] 			 ='Privacy Policy '.SITE_TITLE;
		$data['keyword'] 		 ='Privacy Policy '.SITE_TITLE;
		$data['description'] 	 ='Privacy Policy '.SITE_TITLE;
		$data['content']		 ='web/app-privacy-policy';
		echo Modules::run('template/app_template',$data);
    }
    public function term_condition()
    {
        $data['css_array']       = $this->config->config['insurence_css'];
        $data['title'] 			 ='Term Condition '.SITE_TITLE;
		$data['keyword'] 		 ='Term Condition '.SITE_TITLE;
		$data['description'] 	 ='Term Condition '.SITE_TITLE;
		$data['content']		 ='web/term_condition';
		echo Modules::run('template/web_template',$data);
    }

    public function app_term_condition()
    {
        $data['css_array']       = $this->config->config['insurence_css'];
        $data['title'] 			 ='Term Condition '.SITE_TITLE;
		$data['keyword'] 		 ='Term Condition '.SITE_TITLE;
		$data['description'] 	 ='Term Condition '.SITE_TITLE;
		$data['content']		 ='web/app_term_condition';
		echo Modules::run('template/app_template',$data);
    }
	
	public function app_booking_charges()
    {
        $data['css_array']       = $this->config->config['insurence_css'];
        $data['title'] 			 ='Ride Charges '.SITE_TITLE;
		$data['keyword'] 		 ='Ride Charges '.SITE_TITLE;
		$data['description'] 	 ='Ride Charges '.SITE_TITLE;
		$data['content']		 ='web/booking_charges';
		echo Modules::run('template/app_template',$data);
    }
	
	public function our_support()
    {
        $data['css_array']       = $this->config->config['insurence_css'];
        $data['title'] 			 ='Term Condition '.SITE_TITLE;
		$data['keyword'] 		 ='Term Condition '.SITE_TITLE;
		$data['description'] 	 ='Term Condition '.SITE_TITLE;
		$data['content']		 ='web/app-support';
		echo Modules::run('template/app_template',$data);
    }
    public function insurence()
    {
        $data['css_array']       = $this->config->config['insurence_css'];
        $data['title'] 			 ='Insurence '.SITE_TITLE;
		$data['keyword'] 		 ='Insurence '.SITE_TITLE;
		$data['description'] 	 ='Insurence '.SITE_TITLE;
		$data['content']		 ='web/insurence';
		echo Modules::run('template/web_template',$data);
    }
	
	public function app_insurence()
    {
        $data['css_array']       = $this->config->config['insurence_css'];
        $data['title'] 			 ='Insurence '.SITE_TITLE;
		$data['keyword'] 		 ='Insurence '.SITE_TITLE;
		$data['description'] 	 ='Insurence '.SITE_TITLE;
		$data['content']		 ='web/app-insurence';
		echo Modules::run('template/app_template',$data);
    }
	
	 public function pre_authorized_policy()
    {
        $data['css_array']       = $this->config->config['insurence_css'];
        $data['title'] 			 ='Privacy Policy '.SITE_TITLE;
		$data['keyword'] 		 ='Privacy Policy '.SITE_TITLE;
		$data['description'] 	 ='Privacy Policy '.SITE_TITLE;
		$data['content']		 ='web/app-preauthorized-charges';
		echo Modules::run('template/authorized_template',$data);
    }
}
