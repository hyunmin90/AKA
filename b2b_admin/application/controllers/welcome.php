<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
    {       
        parent::__construct();                
    }

	public function index()
	{
		if($this->session->userdata('state'))
		{
			redirect('/coupon/');
		}
		else 
		{
			
			$this->load->view('loginhead');
			$this->load->view('login');
			//$this->load->view('footer');

			$js['page'] = 'welcome';
			$this->load->view('/jquery/js', $js);
		}	
		

 		//$datas = $this->curl->simple_post(EDGE_WRITINGS.'/writings_api/get_writings', array('secret' => 'isdyf3584MjAI419BPuJ5V6X3YT3rU3C', 'email' => 'admin@akaon.com'));

		//$result = json_decode($datas, true);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */