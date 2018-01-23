<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 19/01/2018
 * Time: 17:09
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Contenuto\Tabellare;


class Linea {

	public $Ddt, $CodiceArticolo, $Descrizione, $Numero, $PrezzoUnitario, $Sconto, $Iva;


	/**
	 * Linea constructor.
	 *
	 * @param $Descrizione
	 * @param $Numero
	 * @param $PrezzoUnitario
	 * @param $Iva
	 * @param $CodiceArticolo
	 * @param int $Sconto
	 * @param array $Ddt
	 */
	public function __construct( $Descrizione , $Numero , $PrezzoUnitario , $Iva , $CodiceArticolo = "", $Sconto = 0, $Ddt = array() ) {
		$this->Ddt            = $Ddt;
		$this->CodiceArticolo = $CodiceArticolo;
		$this->Descrizione    = $Descrizione;
		$this->Numero         = $Numero;
		$this->PrezzoUnitario = $PrezzoUnitario;
		$this->Sconto         = $Sconto;
		$this->Iva            = $Iva;
	}


}