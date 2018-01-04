<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Essa classe é um Singletton que cuida de quando não temos nenhum
 */
class Token extends CI_Controller {

	public function __construct(){
        parent::__construct();
        
    }
    public function index(){
		$data['heading'] = 'Sem Token';
        $data['message'] = 'Entre em contato com o administrador';
        $this->load->view('errors/html/error_general', $data);
	}

}