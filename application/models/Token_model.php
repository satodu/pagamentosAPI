<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token_model extends CI_Model {

        public function __construct(){
            parent::__construct();
        }

        public function getToken($token){	
        	$teste = $this->validToken($token);
        	if($teste == false){
        		redirect('token/notoken','refresh');
        	}
        }

        public function validToken($token){
        	if($token == "8JMVUZDHtmzH"){
        		return true;
        	} 
        	else {
        		return false;
        	}
        }
    }	