<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Coupon extends CI_Controller { 

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();        
        date_default_timezone_set('Asia/Seoul');
    }

    function start_log()
    {
        log_message('error',DEBUG_LINE);
        log_message('error',current_url());
    }

    function index()
    {
        $this->start_log();
        if($this->session->userdata('state'))
        {
            $nav['page'] = 'coupon';
            $this->load->view('head',$nav);

            $division_id = $this->session->userdata('division_id');
            $data = $this->get_event_division($division_id);

            $this->load->view('/coupon/index_view', $data);
            $this->load->view('footer');
            // $js['event_id'] = $event_id;
            $js['page'] = 'coupon_index';
            $this->load->view('/jquery/js', $js);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }

    function get_event_division($division_id)
    {
        if (IS_SSL) {
            $this->curl->ssl(FALSE);
        }       

        $json_datas = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/getEventDivision',array('event_division_id' => $division_id));

        $datas = json_decode($json_datas, true);
        return $datas['data'];
    }

    function get_categories()
    {
        if (IS_SSL) {
            $this->curl->ssl(FALSE);
        }       

        $json_datas = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/getCategories');

        $datas = json_decode($json_datas, true);
        return $datas['data'];
    }

    function get_members($division_id, $admin_id, $event_id = 0)
    {
        if (IS_SSL) {
            $this->curl->ssl(FALSE);
        }       

        $json_datas = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/getMembers', array('event_division_id' => $division_id, 'admin_id' => $admin_id, 'event_id' => $event_id));

        $datas = json_decode($json_datas, true);
        return $datas['data'];
    }

    function get_coupon_count($event_id)
    {
        if (IS_SSL) {
            $this->curl->ssl(FALSE);
        }        
        log_message('error','[DEBUG] get_coupon_count => '.$event_id);

        $json_datas = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/countCoupon', array('event_id' => $event_id));
            
        $datas = json_decode($json_datas, true);
        if ($datas['data']['total'] != '0') {
            $datas['data']['percent'] = $datas['data']['used_count'] * 100 / $datas['data']['total']; 
        } else {
            $datas['data']['percent'] = '0';
        }
        
        //var_dump($datas);
        return $datas['data'];
        //$this->output->set_content_type('application/json')->set_output($json); 
    }

    function get_coupon_usage()
    {
        if (IS_SSL) {
            $this->curl->ssl(FALSE);
        }

        $division_id = $this->session->userdata('division_id');
        $json_datas = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/getDivisionCouponUsage',array('division_id' => $division_id));

        log_message('error','[DEBUG] get_coupon_usage => '.print_r($json_datas,true));
        $datas = json_decode($json_datas, true);
        log_message('error','[DEBUG] get_coupon_usage => '.print_r($datas['data'],true));
        
        //return $json_datas;
        $this->output->set_content_type('application/json')->set_output($json_datas);
    }


    public function create_b2b_user()
    {
        $this->start_log();
        $name = $this->input->get_post('name');
        $email = $this->input->get_post('email');
        $division_id = $this->session->userdata('division_id');
        $admin_id = $this->session->userdata('admin_id');
        if ($division_id != "") {
            log_message('error','[DEBUG] create_b2b_user name => '.$name);
            log_message('error','[DEBUG] create_b2b_user email => '.$email);
            log_message('error','[DEBUG] create_b2b_user division_id => '.$division_id);
            log_message('error','[DEBUG] create_b2b_user admin_id => '.$admin_id);
            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            } 
            $result = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/insert_b2b_member', array('event_division_id' => $division_id, 'admin_id' => $admin_id,  'name' => $name, 'email' => $email));
            log_message('error','[DEBUG] create_b2b_user => '.print_r($result,true));

            $json = $result;   
        } else {
            $json->status = false;
        }

        $this->output->set_content_type('application/json')->set_output($json);     
    }

    function create_assignment()
    {
        $this->start_log();
        if($this->session->userdata('state'))
        {
            $nav['page'] = 'coupon';
            $this->load->view('head',$nav);

            $division_id = $this->session->userdata('division_id');
            $admin_id = $this->session->userdata('admin_id');

            $data['division_info'] = $this->get_event_division($division_id);
            $data['categories'] = $this->get_categories();
            $data['members'] = $this->get_members($division_id, $admin_id);
            //var_dump($data);

            $this->load->view('/coupon/create_assignment',$data);
            $this->load->view('footer');
            // $js['event_id'] = $event_id;
            //$js['page'] = 'coupon_index';
            //$this->load->view('/jquery/js', $js);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }

    function assignment($event_id=0, $mode="")
    {
        $this->start_log();        

        if($this->session->userdata('state'))
        {
            $division_id = $this->session->userdata('division_id');
            $admin_id = $this->session->userdata('admin_id');
            if ($event_id == 0) {
                $event_id = $this->input->post('event_id');
            }
            //
            $nav['page'] = 'coupon';
            $this->load->view('head',$nav);     

            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }       

            $json_datas = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/getEventById', array('event_id' => $event_id, 'event_division_id' => $division_id));
            //var_dump($json_datas);

            $datas = json_decode($json_datas, true);
            $today = date('Y-m-d');
            if ($datas['data']['close_date'] < $today) {
                $datas['closed'] = true;
            }
            else {
                $datas['closed'] = false;
            }
            $datas['categories'] = $this->get_categories();
            $datas['coupon_count'] = $this->get_coupon_count($event_id);
            $datas['current_members'] = $this->get_members($division_id, $admin_id, $event_id);
            if ($mode == "edit") {
                $datas['division_info'] = $this->get_event_division($division_id);
                $datas['members'] = $this->get_members($division_id, $admin_id);
                foreach ($datas['current_members'] as $c_member) {
                    foreach($datas['members'] as $k => $v) {
                        if ($c_member['send_email'] == $v['email']) {
                            unset($datas['members'][$k]);
                        }
                        //print_r ($v);
                    }
                }
            }
            //var_dump($datas);
            
            // log_message('error','[DEBUG] Curl Array => '.print_r($datas,TRUE));
            
            // log_message('error','[DEBUG] Curl Array => '.$datas['data']['get_event_data']['testprep']);
            
            if ($mode == "edit") {
                $this->load->view('/coupon/edit_assignment',$datas);
            } else {
                $this->load->view('/coupon/assignment',$datas);
            }
            $this->load->view('footer');
            $js['event_id'] = $event_id;
            //$js['send_limit'] = $datas['data']['get_event_data']['send_limit'];
            //$js['page'] = 'coupon_send';
            //$this->load->view('/jquery/js', $js);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }




    function get_event_list()
    {
        $this->start_log();
        if($this->session->userdata('state'))
        {               
            $gubun = $this->input->post('gubun');
            $division_id = $this->session->userdata('division_id');
            $admin_id = $this->session->userdata('admin_id');

            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }

            // $json['datas'] = $this->curl->simple_post(EDGE_WRITINGS.'/admin/coupon_api/getEvent', array('event_code' => EVENT_CODE, 'division' => $division));
            $json['datas'] = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/getEvent', array('event_division_id' => $division_id, 'gubun' => $gubun,'admin_id' => $admin_id) );
            log_message('error','[DEBUG] ' . EDGE_WRITINGS . '/admin/b2b_api/getEvent');
            log_message('error','[DEBUG] ' . $division_id  . ' gubun : '. $gubun);

            $datas = json_decode($json['datas'], true);
            
            log_message('error','[DEBUG] Curl Array => '.print_r($datas,TRUE));
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    function event_create()
    {
        $this->start_log();
        if($this->session->userdata('state'))
        {
            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }

            $b2b_params['title'] = $this->input->get_post('title');
            $b2b_params['desc'] = $this->input->get_post('desc');
            $b2b_params['message'] = $this->input->get_post('message');
            $b2b_params['product_id'] = $this->input->get_post('product_id');
            $b2b_params['start'] = $this->input->get_post('start');
            $b2b_params['close'] = $this->input->get_post('close');
            $b2b_params['discount'] = $this->input->get_post('discount');
            $b2b_params['limit'] = $this->input->get_post('limit');
            $b2b_params['cates'] = $this->input->get_post('cates');
            $b2b_params['members'] = $this->input->get_post('members');
            $b2b_params['division_id'] = $this->input->get_post('division_id');
            $b2b_params['limitCount'] = $this->input->get_post('limitCount');
            $b2b_params['admin_id'] = $this->session->userdata('admin_id');


            // $json['datas'] = $this->curl->simple_post(EDGE_WRITINGS.'/admin/coupon_api/getEvent', array('event_code' => EVENT_CODE, 'division' => $division));
            $json = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/insert_b2b_event', $b2b_params);
                       
            log_message('error','[DEBUG] insert_b2b_event result => ' . $json);
            $this->output->set_content_type('application/json')->set_output($json);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }

    }

    function event_update()
    {
        $this->start_log();
        if($this->session->userdata('state'))
        {
            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }

            $b2b_params['id'] = $this->input->get_post('id');
            $b2b_params['title'] = $this->input->get_post('title');
            $b2b_params['desc'] = $this->input->get_post('desc');
            $b2b_params['message'] = $this->input->get_post('message');
            $b2b_params['product_id'] = $this->input->get_post('product_id');
            $b2b_params['start'] = $this->input->get_post('start');
            $b2b_params['close'] = $this->input->get_post('close');
            $b2b_params['discount'] = $this->input->get_post('discount');
            $b2b_params['limit'] = $this->input->get_post('limit');
            $b2b_params['cates'] = $this->input->get_post('cates');
            $b2b_params['members'] = $this->input->get_post('members');
            $b2b_params['division_id'] = $this->input->get_post('division_id');
            $b2b_params['limitCount'] = $this->input->get_post('limitCount');
            $b2b_params['admin_id'] = $this->session->userdata('admin_id');


            // $json['datas'] = $this->curl->simple_post(EDGE_WRITINGS.'/admin/coupon_api/getEvent', array('event_code' => EVENT_CODE, 'division' => $division));
            $json = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/update_b2b_event', $b2b_params);
                       
            log_message('error','[DEBUG] update_b2b_event result => ' . $json);
            $this->output->set_content_type('application/json')->set_output($json);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }

    }

    
    function send()
    {
        $this->start_log();        

        if($this->session->userdata('state'))
        {
            $event_id = $this->input->post('event_id');
            $nav['page'] = 'coupon';
            $this->load->view('head',$nav);     

            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }       

            $admin_id = $this->session->userdata('admin_id');
            $json_datas = $this->curl->simple_post(EDGE_WRITINGS.'/admin/coupon_api/univ_send', array('data_id' => $event_id, admin_id => $admin_id));

            $datas = json_decode($json_datas, true);
            
            // log_message('error','[DEBUG] Curl Array => '.print_r($datas,TRUE));
            
            // log_message('error','[DEBUG] Curl Array => '.$datas['data']['get_event_data']['testprep']);
            
            $this->load->view('/coupon/coupon_send_view',$datas);
            $this->load->view('footer');
            $js['event_id'] = $event_id;
            $js['send_limit'] = $datas['data']['get_event_data']['send_limit'];
            $js['page'] = 'coupon_send';
            $this->load->view('/jquery/js', $js);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }

    function deactivate()
    {
        $this->start_log();        

        if($this->session->userdata('state'))
        {
            $coupon_id = $this->input->post('coupon_id');

            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }

            log_message('error','[DEBUG] deactivate coupon_id => ' . $coupon_id);
            $json = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/deactivate', array('coupon_id' => $coupon_id));
            log_message('error','[DEBUG] deactivate result => ' . $json);
            
            $this->output->set_content_type('application/json')->set_output($json);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }

    function reactivate()
    {
        $this->start_log();        

        if($this->session->userdata('state'))
        {
            $coupon_id = $this->input->post('coupon_id');

            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }

            log_message('error','[DEBUG] reactivate coupon_id => ' . $coupon_id);
            $json = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/reactivate', array('coupon_id' => $coupon_id));
            log_message('error','[DEBUG] reactivate result => ' . $json);
            
            $this->output->set_content_type('application/json')->set_output($json);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    } 


    function couponCount()
    {   
	    $event_id = $this->input->get_post('event_id');
        log_message('error','[DEBUG] Count coupon => '.$event_id);

        $json['datas'] = $this->curl->simple_post(EDGE_WRITINGS.'/admin/coupon_api/countCoupon', array('event_id' => $event_id));
            
        //$datas = json_decode($json['datas'], true);
        //log_message('error','[DEBUG] Curl Array => '.print_r($datas,TRUE));
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    function submit()
    {
        $this->start_log();        

        if($this->session->userdata('state'))
        {
            $emails = $this->input->post('emails');
            $event_id = $this->input->post('event_id');
            $nav['page'] = 'coupon';
            $this->load->view('head',$nav);

            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }

            $json['datas'] = $this->curl->simple_post(EDGE_WRITINGS.'/admin/coupon/exterior_submit_api', array('emails' => $emails, 'event_id' => $event_id));
            
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }   

    function total()
    {
        $this->start_log();        

        if($this->session->userdata('state'))
        {            
            $event_id = $this->input->post('event_id');   

            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }         

            $json['datas'] = $this->curl->simple_post(EDGE_WRITINGS.'/admin/coupon_api/getEventCoupons', array('event_id' => $event_id));
            
            // $datas = json_decode($json['datas'], true);
            // log_message('error','[DEBUG] Curl Array => '.print_r($datas,TRUE));
            
            $this->output->set_content_type('application/json')->set_output(json_encode($json));

        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }
}
?>
