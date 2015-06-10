<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	function __construct()
    {    
        parent::__construct();
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));        
    }


    function start_log(){
		log_message('error',DEBUG_LINE);
		log_message('error',current_url());
	}   
	
	function index()
	{
		$this->start_log();
        $name = $_FILES['userfile']['name']; // get file name from form

        log_message('error','[DEBUG] Filename => '.$name);
        log_message('error','[DEBUG] File Size => '.$_FILES['userfile']['size']);
        
        $config['file_name'] = $name; //set file name
        $config['upload_path'] = '/var/www/edgewritings/images/mail_notice/images/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['max_size'] = '0';
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        $config['overwrite'] = true;
        //$config['encrypt_name'] = TRUE; // 파일명 암호화.
        
        $this->load->library('upload', $config);        
    
        if( ! $this->upload->do_upload())
        {
            $result = strip_tags($this->upload->display_errors());
            
            echo '<script>                    
                    alert("'.$result.'");
                    </script>'; 
            
            log_message('error','[DEBUG] Upload false');
            log_message('error','[DEBUG] Upload Error message => '.$this->upload->display_errors());
        }   
        else
        {   
            $data = $this->upload->data();          
            $filename = $data['file_name'];           
            
            log_message('error','[DEBUG] Upload true');
            echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
            echo "<br/><b>File Name:</b> " . $_FILES["userfile"]["name"] . "<br>";
            echo "<b>Type:</b> " . $_FILES["userfile"]["type"] . "<br>";
            echo "<b>Size:</b> " . ($_FILES["userfile"]["size"] / 1024) . " kB<br>";
            echo "<b>Temp file:</b> " . $_FILES["userfile"]["tmp_name"] . "<br>";
                      
        }
	}
}
?>