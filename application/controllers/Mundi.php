<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH.'third_party/mundipagg-one-php/init.php';

class Mundi extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $token = $this->uri->segment(1);
        $this->load->model('Token_model');
		$this->Token_model->getToken($token);
    }

    /**
     * [getparcelas Retorna o número de parcelas que foi feita a compra]
     * @param  [type] $id [Order reference]
     * @return [type]     [Constroi o JSON com o número da order e o número de parcelas]
     */
    public function getparcelas($id){
    	$result = $this->buildModelAndGetFullData($id);
    	$checkPagamento = $this->checkTypeOfPayment($id);
    	if($checkPagamento == "Cartão de crédito"){
			$data['dados'] = array(
				'OrderReference' => $result['OrderReference'], 
				'Parcelas' => $result['queryResult']->SaleDataCollection[0]->CreditCardTransactionDataCollection[0]->InstallmentCount,
				'Bandeira' => $result['queryResult']->SaleDataCollection[0]->CreditCardTransactionDataCollection[0]->CreditCard->CreditCardBrand);
			return $this->load->view('helper/json', $data);
		}
		else {
			$data['heading'] = 'Pagamento não foi feito no cartão';
        	$data['message'] = 'Verifique no sistema o meio de pagamento';
			return $this->load->view('errors/html/error_general', $data);
		}
	}

	/**
	 * [checkTypeOfPayment Checa o tipo de pagamento]
	 * @param  [Interger] $id [Order Reference da Mundipagg]
	 * @return [String]     [Retorna o tipo de pagamento usado]
	 */
	public function checkTypeOfPayment($id){
		$result = $this->buildModelAndGetFullData($id);
		$card = $result['queryResult']->SaleDataCollection[0]->CreditCardTransactionDataCollection[0];
		$boleto = $result['queryResult']->SaleDataCollection[0]->BoletoTransactionDataCollection[0];
		if( $card == NULL ){
			$pagamento = "Boleto Bancário";
		}else {
			$pagamento = "Cartão de crédito";
		}
		return $pagamento;
	}

	/**
	 * [buildModelAndGetFullData Faz conexão com Query Geral de compras da Mundi e pega o 4 Item do segmento]
	 * @param  [type] $id [Segmento 4 da URL]
	 * @return [type] [Retorna u Objeto com os dados de compra]
	 */
    private function buildModelAndGetFullData($id){
    	$this->load->model('Mundi_model');
		$OrderReference = $this->uri->segment(4);
		$result = $this->Mundi_model->queryFullDataOfPurchase($OrderReference);
		return array ('OrderReference' => $OrderReference , 'queryResult' => $result);
    }
}
