<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    var $id = '';
    var $name = '';
    var $email = '';
    var $password = '';
    var $date = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        date_default_timezone_set('Asia/Seoul');
    }

    function get()
    {
        $this->db->order_by("date", "desc");
        $query = $this->db->get_where('user');
        return $query->result();
    }

    function find($params)
    {
        $query = $this->db->get_where('user', $params, 1);

        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }    

    function auth($params)
    {
        $password = $params['password'];
         unset($params['password']);

        $query = $this->db->get_where('user', $params, 1);

        if($query->num_rows() > 0)
        {
            $decode_password = $this->encrypt->decode($query->row()->password);

            if($decode_password == $password)
            {
                 return $query->row();
             }
             else
             {
                 return false;
             }
        }       
        return false;
        
    }

    function add($params)
    {
        unset($this->id);
	    $this->name = $params['name'];
	    $this->email = $params['email'];
	    $this->password = $this->encrypt->encode(($params['password']));
	    $this->date = date('Y-m-d H:i:s',now());

        return $this->db->insert('user', $this);
    }

    function update($params, $id)
    {
        $where = array();
        $where['id'] = $id;
        if(isset($params['password'])) $params['password'] = $this->encrypt->encode($params['password']);
        return $this->db->update('user', $params, $where);
    }

    function get_country()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        //$ip = '182.225.201.6'; // kr
        //$ip = '74.125.45.100'; // us
        log_message('error','[DEBUG] IP => '.$ip);        

        return $this->db->query('SELECT country FROM ip2nation WHERE ip < INET_ATON("'.$ip.'") ORDER BY ip DESC LIMIT 0,1');        
    }
}

?>