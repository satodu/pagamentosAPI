<?php

class Mundi_model extends CI_Model {
        public function __construct(){
            parent::__construct();
        }

        public function queryFullDataOfPurchase($OrderReference){
        	try {
			    // Define a url utilizada
			    \Gateway\ApiClient::setBaseUrl("https://transactionv2.mundipaggone.com");

			    // Define a chave da loja
			    \Gateway\ApiClient::setMerchantKey("Token para Conexão");

			    //Cria um objeto ApiClient
			    $client = new Gateway\ApiClient();
			    // Faz a chamada para criação
			    $response = $client->searchSaleByOrderReference($OrderReference);
			    return $response->getData();
			}
			catch (\Gateway\One\DataContract\Report\ApiError $error) {
				return json_encode($error, JSON_PRETTY_PRINT);
			}
			catch (Exception $ex) {
			    return json_encode($ex, JSON_PRETTY_PRINT);
			}
        }
}