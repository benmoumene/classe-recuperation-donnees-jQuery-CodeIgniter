<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jaz_model extends MY_Model {
    
     /**
     * The database table to use.
     * @var string
     */
    public $table_name = '';
    
    /**
     * Primary key field
     * @var string
     */
    public $primary_key = '';
    
    /**
     * Order by fields. Default order for this model.
     * @var string
     */
    public $order_by = '';
    
    function __construct() {
        parent::__construct();
    }
    
	function activate_account($email) 
	{
		$q = $this->db->select('email, active')
				 ->from('users')
				 ->where('email', $email)
				 ->limit(1)
				 ->get();

		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			
			//to access the content use sample below
			//echo '<br>email: ' . $data[0]->email;
			
			$this->db->where('email', $email)
					 ->set('active', 1)
					 ->update('users'); 			
			
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}	

	//Get record by email as a signal only if record exist.
	function select_by_email($email) 
	{
		$q = $this->db->select('username, password, email, active')
				 ->from('users')
				 ->where('email', $email)
				 ->limit(1)
				 ->get();

		return $q->num_rows() > 0; //This will return TRUE if the email exist.
	}	
		
	//Get record by email
	function get_username($email) 
	{
		$q = $this->db->select('username, email')
				 ->from('users')
				 ->where('email', $email)
				 ->limit(1)
				 ->get();

		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			
			return $data[0]->username;
		}
		else 
		{
			return FALSE;	
		}
	}	

	//get user(s) email(s)
	function get_user_email($user, $chkbox)
	{
		//If everything is not set then return FALSE
		if(empty($user) && $chkbox==FALSE) 
		{
			return FALSE;
		}
		
		//fetch username email if username is not empty and $chkbox is FALSE.
		if($chkbox == FALSE) {
			$q = $this->db->select('email')
					 ->from('users')
					 ->where('username', $user)
					 ->get();
		}
		 
		//fetch all members emails if $chkbox is checked as TRUE.
		if($chkbox == TRUE) {
			$q = $this->db->select('email')
					 ->from('users')
					 ->get();
		}		

		if($q->num_rows() > 0) 
		{
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			
			return $data;
		}
	}

	//Check username is exist.
	function check_username($user)
	{
		$q = $this->db->select('username')
				 ->from('users')
				 ->where('username', $user)
				 ->limit(1)
				 ->get();
				 
		if($q->num_rows() > 0) {
			return TRUE;
		}
		else 
		{
			return FALSE;	
		}
	}

	function reset_password($user, $pass)
	{
		//encryp password
		$epass = sha1($pass);
		
		$this->db->where('username', $user)
				 ->set('password', $epass)
				 ->update('users');	

		
			
		if($this->db->affected_rows() > 0) 
		{
			return TRUE;		
		}
		else 
		{
	
			//return FALSE;
		}
		
	}

	function delete_user($user)
	{
        if (empty($user)) {
            return FALSE;
        }
		
		//get userid
		$userid = $this->get_user_id($user);
		
		//delete user in users table
		$this->db->delete('users', array('username' => $user));
		$table1 = ($this->db->affected_rows() > 0) ?  TRUE : FALSE;
	
		//delete user in profile table
		$this->db->delete('profile', array('userid' => $userid));
		$table2 = ($this->db->affected_rows() > 0) ?  TRUE : FALSE;
		
		//If both table successfuly deleted a record.
		return ($table1 &&  $table2) ? TRUE : FALSE;
	}
	
	//Get userid by username
	function get_user_id($user)
	{
		$q = $this->db->select('id, username')
				 ->from('users')
				 ->where('username', $user)
				 ->limit(1)
				 ->get();
				 
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				//$data[] = $row;
				$data = $row->id;
			}
			
			return $data;
		}
	}
	
	//Get total numbers of Admins, Mods and Users
	function total_number()
	{
		$admin_cnt = $this->db->select('group_id')
				 ->from('users')
				 ->where('group_id', 1)
				 ->where('active', 1)
				 ->get();
				 
		$total_cnt['admin_cnt'] = $admin_cnt->num_rows();

		$user_cnt = $this->db->select('group_id')
				 ->from('users')
				 ->where('group_id', 2)
				 ->where('active', 1)
				 ->get();

		$total_cnt['user_cnt'] = $user_cnt->num_rows();
			
		return $total_cnt;
	}
	
 	//Ban a user
	function ban_user($user, $reason)
	{
		//Save username and reason into ban	table.
		$data = array(
		   'username' => $user,
		   'reason' => $reason 
		);
		
		$this->db->insert('ban', $data); 

		if($this->db->affected_rows() > 0) 
		{
			return TRUE;		
		}
		else 
		{
			return FALSE;
		}
	}

	function unban_user($user)
	{
		//Delet username from ban record list.
		$this->db->delete('ban', array('username' => $user)); 

		if($this->db->affected_rows() > 0) 
		{
			return TRUE;		
		}
		else 
		{
			return FALSE;
		}
	}
	
	//Check if user is ban or if record exist in the ban table.
	function is_ban($user) 
	{
		$q = $this->db->select('username')
				 ->from('ban')
				 ->where('username', $user)
				 ->limit(1)
				 ->get();

		return $q->num_rows() > 0; //This will return TRUE or false depending on the query result.
	}
	
	//Check if user is ban or if record exist in the ban table.
	function is_member($user) 
	{
		$q = $this->db->select('username')
				 ->from('users')
				 ->where('username', $user)
				 ->limit(1)
				 ->get();

		return $q->num_rows() > 0; //This will return TRUE or false depending on the query result.
	}

}


