<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
    function __construct() {
        parent::__construct();
    }

    public function get_loaded_classes()
    {
        return $this->_ci_classes;
    }
    public function get_loaded_helpers()
    {
        $loaded_helpers = array();
        if(sizeof($this->_ci_helpers)!== 0) {
            foreach ($this->_ci_helpers as $key => $value)
            {
                $loaded_helpers[] = $key;
            }
        }
        return $loaded_helpers;
    }
    public function get_loaded_models()
    {
        return $this->_ci_models;
    }	
}