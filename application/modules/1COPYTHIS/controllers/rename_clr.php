<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rename_ctrlr extends MX_Controller
{
	
/*****************************************************
 * Perfect controller methods
 *****************************************************/
	function __construct() {
		 parent::__construct();
	    $this->load->model('rename_mdl');
		 
	 }
	
	function get($order_by){
	    $query = $this->rename_mdl->get($order_by);
	    return $query;
	 }
	
	function get_with_limit($limit, $offset, $order_by) {
	    $query = $this->rename_mdl->get_with_limit($limit, $offset, $order_by);
	    return $query;
	 }
	
	function get_where($id){
	    $query = $this->rename_mdl->get_where($id);
	    return $query;
	 }
	
	function get_where_custom($col, $value) {
	    $query = $this->rename_mdl->get_where_custom($col, $value);
	    return $query;
	 }
	
	function _insert($data){
	    $this->rename_mdl->_insert($data);
	 }
	
	function _update($id, $data){
	    $this->rename_mdl->_update($id, $data);
	 }
	
	function _delete($id){
	    $this->rename_mdl->_delete($id);
	 }
	
	function count_where($column, $value) {
	    $count = $this->rename_mdl->count_where($column, $value);
	    return $count;
	 }
	
	function get_max() {
	    $max_id = $this->rename_mdl->get_max();
	    return $max_id;
	 }
	
	function _custom_query($mysql_query) {
	    $query = $this->rename_mdl->_custom_query($mysql_query);
	    return $query;
	 }

/*****************************************************
 * Miscellaneous methods
 *****************************************************/
 
 

	

}

