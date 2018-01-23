<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 17/01/2018
 * Time: 17:10
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt;

use ItalianInvoiceDdt\Contenuto\ParteDescrittiva;
use ItalianInvoiceDdt\Contenuto\ParteTabellare;
use ItalianInvoiceDdt\Documenti\Ddt;
use ItalianInvoiceDdt\Documenti\Fattura;

class ItalianInvoiceDdt {


	public $ParteDescrittiva, $ParteTabellare, $Fattura;

	public function __construct() {

		$this->ParteDescrittiva = new ParteDescrittiva();

		$this->ParteTabellare = new ParteTabellare();


	}


	public function StampaFattura() {


		$Fattura = new Fattura( $this->ParteDescrittiva, $this->ParteTabellare );

		$Fattura->Stampa();


	}

	public function StampaDdt() {

		$Ddt = new Ddt( $this->ParteDescrittiva, $this->ParteTabellare );

		$Ddt->Stampa();

	}


}

