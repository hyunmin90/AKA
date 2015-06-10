<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CI_Controller {

	function __construct()
    {    
        parent::__construct();

        // date_default_timezone_set('Asia/Seoul');
        // $this->load->library('email');
    }


    function start_log(){
		log_message('error',DEBUG_LINE);
		log_message('error',current_url());
	}   
	
	function index()
	{
		$this->start_log();
		if($this->session->userdata('state'))
        {               
            $nav['page'] = 'image';
            $this->load->view('head',$nav);

            $this->load->view('/image/index_view');
            
            // $js['event_id'] = $event_id;
            $js['page'] = 'image';
            $this->load->view('/jquery/js', $js);            
            $this->load->view('footer');
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }

	}
}
?>