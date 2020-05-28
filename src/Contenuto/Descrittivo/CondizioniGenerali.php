<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 17/01/2018
 * Time: 22:42
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Contenuto\Descrittivo;


class CondizioniGenerali {

	public $pagamento,$consegna,$imballaggio;

	/**
	 * @param mixed $pagamento
	 */
	public function setPagamento( $pagamento ) {
		$this->pagamento = $pagamento;
	}

	/**
	 * @param mixed $consegna
	 */
	public function setConsegna( $consegna ) {
		$this->consegna = $consegna;
	}

	/**
	 * @param mixed $imballaggio
	 */
	public function setImballaggio( $imballaggio ) {
		$this->imballaggio = $imballaggio;
	}
}