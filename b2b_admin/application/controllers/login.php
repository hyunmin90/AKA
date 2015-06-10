<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
	
	function localCountry()
	{
		$sql = $this->user_model->get_country();	
		if($sql->num_rows() > 0)
		{
			$result = $sql->row();	
			$country = $result->country;
			log_message('error','[DEBUG] Country => '.print_r($result,true));
		}
		else // DB에 없는 IP 라면 무조건 미국에서 접속한것으로 간주하고 Paypal로 결제를 연동한다.
		{
			$country = 'en';
			log_message('error','[DEBUG] Country => '.$country);
		}
		return $country;
	}

	function send_email($to, $subject, $message)
	{
		// $email_setting = Array(
		// 	  'protocol' => 'smtp',
		// 	  'smtp_host' => 'ssl://smtp.gmail.com',
		// 	  'smtp_port' => 465,
		// 	  'smtp_user' => 'info@akaon.com', // change it to yours
		// 	  'smtp_pass' => 'aka5377201', // change it to yours
		// 	  'mailtype' => 'html'
		// );	

		//$this->email->initialize($email_setting);

		$this->email->from(MAIL_ADDRESS, 'EDGE Writings');
		$this->email->to($to); 
		$this->email->set_mailtype("html");	
		$this->email->bcc(MAIL_ADDRESS);

		$this->email->subject($subject);
		$this->email->message($message);	
		return $this->email->send();
	}

	public function index()
	{		
		if($this->session->userdata('state'))
		{
			redirect('/');
		}

		$country = $this->localCountry();
		log_message('error','[DEBUG] Welcome country => '.$country);

		$this->session->set_userdata('country', $country);
		$this->session->set_userdata('redirect', current_url());
		
		$nav['page'] = 'login';
		$this->load->view('head');
		$this->load->view('nav', $nav);

		$this->load->view('me/sign');
		$js['page'] = 'me_sign';		
		
		$this->load->view('footer');
		$this->load->view('js', $js);
	}	

	public function sign_in()
	{
		$this->start_log();
		//log_message('error', '에러');

		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$encoded_password = $this->encrypt->encode($password);
		log_message('error','[DEBUG] sign_in => '.$email);
		log_message('error','[DEBUG] sign_in => '.$password);
		log_message('error','[DEBUG] sign_in => '.$encoded_password);

		if (IS_SSL) {
			$this->curl->ssl(FALSE);
		}

		$json_data = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/login', array('email' => $email, 'password' => $encoded_password));

		log_message('error','[DEBUG] sign_in => '.$json_data);
		//print_r($json_datas);
	          $data = json_decode($json_data, true);
	          //print_r($data);

		if($data['status'])
		{
			$userdata = array('state' => true, 'user_id' => $data['data']['id'], 'user_name' => $data['data']['name'], 'division_id' => $data['data']['division_id'], 'admin_id' => $data['data']['admin_id']);
			$this->session->set_userdata($userdata);
			$json['status'] = true;
		}		

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/**
	public function sign_up()
	{
		$this->start_log();

		$params['email'] = $this->input->post('email');
		if(valid_email($params['email']))
		{
			if(!$user = $this->user_model->find($params))
			{
				$params['name'] = $this->input->post('name');
				$params['email'] = $this->input->post('email');
				$params['password'] = $this->input->post('password');

				if($this->user_model->add($params))
				{
					if($user = $this->user_model->auth($params))
					{
						log_message('error','[DEBUG] New Sign up => '.$user->name);
						
						$userdata = array('state' => true, 'user_id' => $user->id, 'user_name' => $user->name, 'email' => $user->email);
						
						$this->session->set_userdata($userdata);			
						$data['redirect'] = $this->session->userdata('redirect');			
						$this->json->status = true;						
						$this->json->data = $data;
					}
					else
					{
						$this->json->set_error(209);
					}
				}
				else
				{
					$this->json->set_error(101);
				}
			}
			else
			{
				$this->json->set_error(208);
			}
		}
		else
		{
			$this->json->set_error(207);
		}
		
		$this->json->output();
	}
	**/

	public function forgot_password()
	{
		$params = array();
		$params['email'] = $this->input->post('email');
		log_message('error','[DEBUG] Email =>'.$params['email']);

		if($user = $this->user_model->find($params))
		{
			$params = array();
			$params['password'] = strtolower(random_string('alpha', 8));

			$to = $this->input->post('email');
			$subject = 'EDGE Writings - Password';
			$temp_password = $params['password'];

			$nick_name = $user->name;
			
			$style = 'font-size:14px; color:#777; margin-right: 13px; text-decoration:none;';

			log_message('error','[DEBUG] Email =>'.$nick_name);
			$message = '
						<table background="'.WRITINGS_URL.'/images/mail_password.png" style="background-repeat:no-repeat;" width="738px"; height="344px"; >
							<tbody>
								<tr>
						          <td style="margin-left:10px;">
						            <div>
						              <br><br><br><br><br>
						              <p style="text-align:center; font-size:16px;"><b>Hi '.$nick_name.'!</b></p>
						              <p style="text-align:center;">This is your new temporary password : <span style="color:#55bbcf;">'.$temp_password.'</span></p>
						              <p style="text-align:center; color:#55bbcf;"><a href="'.WRITINGS_URL.'" target="_blank" style="text-decoration : none;" >www.edgewritings.com</a></p>
						              <br>
						              <p style="text-align:center;"><strong>The EDGE WRITINGS team.</strong></p>
						              <br>
						              <p class="text-muted credit" style="font-size:12px; text-align:right; margin-right:40px;">EDGE Writings &nbsp;<a href="http://akaon.com/">AKAON.COM</a> &nbsp;Copyright 2014</p>
						            </div>
						          </td>
						        </tr>						        
				      		</tbody>
			      		</table>
						';
			if($this->send_email($to, $subject, $message))
			{
				log_message('error','[DEBUG] Email send success');
				if($this->user_model->update($params, $user->id))
				{
					$this->json->status = true;
				}
				else
				{
					$this->json->set_error(103);
				}
			}
			else
			{
				$this->json->set_error(104);
			}
		}
		else
		{
			$this->json->set_error(102);
		}
		$this->json->output();
	}

	public function change_password()
	{
		if($params['password'] = $this->input->post('password'))
		{
			if($this->user_model->update($params, $this->session->userdata('user_id')))
			{
				$this->json->status = true;
			}
			else
			{
				$this->json->set_error(103);
			}
			$this->json->output();
		}
		else
		{
			$nav['page'] = 'me';

			$this->load->view('head');
			$this->load->view('nav', $nav);

			if($this->session->userdata('state'))
			{
				$params['id'] = $this->session->userdata('user_id');
				if($user = $this->user_model->find($params))
				{
					$me['user'] = $user;
					$this->load->view('me/change_password', $me);
					$js['page'] = 'me_change_password';
				}
				else
				{
					$this->session->sess_destroy();

					$this->load->view('me/sign');
					$js['page'] = 'me_sign';
				}
			}
			else
			{
				$this->load->view('me/sign');
				
			}
			
			$this->load->view('footer');
			$this->load->view('js', $js);
		}
	}

	public function sign_out()
	{
		$this->session->sess_destroy();
		redirect('/');		
	}	
}
?>