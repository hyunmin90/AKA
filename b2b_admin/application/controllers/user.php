<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require_once 'date_diff.php';
class User extends CI_Controller { 

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
            $nav['page'] = 'user';
            $this->load->view('head',$nav);

            $division_id = $this->session->userdata('division_id');
            $admin_id = $this->session->userdata('admin_id');
            $event_id = 0;

            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }

            $datas = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/getMembers', array('event_division_id' => $division_id, 'admin_id' => $admin_id, 'event_id' => $event_id));

            $result = json_decode($datas, true);

            //var_dump($result);

            // log_message('error','[DEBUG] Curl Array => '.print_r($result,TRUE));           

            $this->load->view('/user/index_view',$result);
            $this->load->view('footer');
            //$js['page'] = 'users';
            //$js['user_count'] = count($result['data']);
            //$this->load->view('/jquery/js', $js);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }

    function detail($member_id)
    {
        $this->start_log();
        if($this->session->userdata('state'))
        {
            $nav['page'] = 'user';
            $this->load->view('head',$nav);

            $division_id = $this->session->userdata('division_id');
            $admin_id = $this->session->userdata('admin_id');
            $event_id = 0;

            if (IS_SSL) {
                $this->curl->ssl(FALSE);
            }

            $datas = $this->curl->simple_post(EDGE_WRITINGS.'/admin/b2b_api/getMemberDetail', array('member_id' => $member_id));

            $result = json_decode($datas, true);
            //var_dump($result);

            // log_message('error','[DEBUG] Curl Array => '.print_r($result,TRUE));           

            $this->load->view('/user/detail_view',$result);
            $this->load->view('footer');
            //$js['page'] = 'users';
            //$js['user_count'] = count($result['data']);
            //$this->load->view('/jquery/js', $js);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }
}
?>