<?php
class Users_model extends MY_Model
{

    function __construct (){
        parent::__construct();
        $this->table_name1 = 'users';
		$this->table_name2 = 'profile';
        $this->primary_key = 'id';
        $this->order_by = 'id DESC'; //must be date
    }

}