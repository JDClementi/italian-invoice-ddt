<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 17/01/2018
 * Time: 22:19
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Contenuto;


use ItalianInvoiceDdt\Contenuto\Tabellare\Linea;

class ParteTabellare {

	public $Linee = array();

	public $totale = 0;

	public $totaleAliquote = array();


	public function addLinea( $Descrizione, $Numero, $PrezzoUnitario, $Iva, $CodiceArticolo = "", $Sconto = 0, $Ddt = array('Numero' => '1243',
	                                                                                                                        'Data'   => '13/04/2017') ) {

		$this->Linee[] = new Linea( $Descrizione, $Numero, $PrezzoUnitario, $Iva, $CodiceArticolo, $Sconto, $Ddt );

		$PrezzoRiga = round( $Numero * $PrezzoUnitario, 2 );


		$this->totale += $PrezzoRiga;

		if ( ! isset( $this->totaleAliquote[ $Iva ] ) ) {

			$this->totaleAliquote[ $Iva ] = $PrezzoRiga;

		} else {

			$this->totaleAliquote[ $Iva ] += $PrezzoRiga;

		}

		/*echo "<h1>totale riga</h1>";
		echo "<pre>";
		var_dump( $PrezzoRiga );
		echo "</pre>";
		echo "<h1>iva:</h1>";
		echo "<pre>";
		var_dump( $Iva );
		echo "</pre>";
		echo "<h1>totale aliquote</h1>";
		echo "<pre>";
		foreach ( $this->totaleAliquote as $iva => $totale ) {
			echo "<h4>iva: $iva</h4>";
			echo "<pre>";
			echo "totale imponibile : <br>";

			var_dump( $totale );
			echo "</pre>";
		}
		echo "</pre>";*/

	}

	/**
	 * @return int
	 */
	public function getTotale() {
		return $this->totale;
	}


}