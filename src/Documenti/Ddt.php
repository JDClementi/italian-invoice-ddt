<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 23/01/2018
 * Time: 10:41
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Documenti;

use ItalianInvoiceDdt\Forma\LayoutDdt;


class Ddt extends LayoutDdt {


	public $Linee;

	public $Aliquote;

	public $ParteTabellare;

	public $ParteDescrittiva;


	public function __construct( $ParteDescrittiva, $ParteTabellare ) {

		parent::__construct( $ParteDescrittiva->Venditore, $ParteDescrittiva->Compratore );

		$this->Linee          = $ParteTabellare->Linee;
		$this->Aliquote       = $ParteTabellare->totaleAliquote;
		$this->ParteTabellare = $ParteTabellare;

		$this->ParteDescrittiva = $ParteDescrittiva;
	}


	public function Stampa() {


		$this->AliasNbPages();

		$this->AddPage();

		$this->StampaRigheDettaglio();

		$this->Output();

	}





	public function StampaRigheDettaglio(){

		$this->SetY($this->QuotaSuperioreStampaTabellaDettagli);

		foreach ( $this->Linee as $Linea ) {


			$ProductsLine = array(

				array(
					'width' => parent::$LarghezzaCodice,
					'txt'   => $Linea->CodiceArticolo,
					'align' => 'C'
				),
				array(
					'width' => parent::$LarghezzaCausale,
					'txt'   => 'V',
					'align' => 'C'
				),
				array(
					'width' => parent::$LarghezzaDescrizione,
					'txt'   => $Linea->Descrizione,
					'align' => 'C'
				),
				array(
					'width' => parent::$LarghezzaQuantita,
					'txt'   => parent::FormattaNumero($Linea->Numero),
					'align' => 'R'
				),
				array(
					'width' => parent::$LarghezzaPrezzoUnitario,
					'txt'   =>  parent::FormattaNumero( $Linea->PrezzoUnitario ),
					'align' => 'R'
				),
				array(
					'width' => parent::$LarghezzaSconto,
					'txt'   => parent::FormattaNumero( $Linea->Sconto ),
					'align' => 'C'
				),
				array(
					'width' => parent::$LarghezzaImporto,
					'txt'   => parent::FormattaNumero( round( $Linea->Numero * $Linea->PrezzoUnitario, 2 ) ),
					'align' => 'C'
				),
				array(
					'width' => parent::$LarghezzaIva,
					'txt'   => $Linea->Iva,
					'align' => 'C'
				),

			);

			$this->PrintDettagliTableRow( $ProductsLine, $this->QuotaSuperioreStampaTabellaDettagli, $this->QuotaInferioreStampaTabellaDettagli );

		}

	}


	public function PrintDettagliTableRow( $data, $minHeight, $maxHeight ) {
		//Calculate the height of the row
		$nb = 0;
		for ( $i = 0; $i < count( $data ); $i ++ ) {
			$nb = max( $nb, $this->NbLines( $data[ $i ]['width'], $data[ $i ]['txt'], ( isset( $data[ $i ]['font'] ) ? $data[ $i ]['font'] : false ) ) );
		}
		$h = 5 * $nb;

		//Issue a page break first if needed
		if ( $this->GetY() + $h > $maxHeight ) {
			$this->SetFont( 'Arial', 'B', 11 );
			//$this->SetXY( $this->MargineSinistroImporto, $this->QuotaTotaleAPagare );
			//$this->Cell( parent::$MargineDestroTabellaDettagli - $this->MargineSinistroImporto, 7, 'SEGUE', 0, 0, 'C', false );
			$this->AddPage( $this->CurOrientation );
			$this->StampaCampiDescrittivi();
			$this->SetY( $minHeight );
		}

		//Draw the cells of the row
		for ( $i = 0; $i < count( $data ); $i ++ ) {
			$w = $data[ $i ]['width'];
			$a = isset( $data[ $i ]['align'] ) ? $data[ $i ]['align'] : 'L';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();

			//Print the text
			$MultiCellHeight = $h / $this->NbLines( $w, $data[ $i ]['txt'] );
			if ( isset( $data[ $i ]['font'] ) ) {
				$this->SetFont( $data[ $i ]['font']['family'], $data[ $i ]['font']['style'], $data[ $i ]['font']['size'] );
			}
			$this->MultiCell( $w, $MultiCellHeight, $data[ $i ]['txt'], 0, $a );
			if ( isset( $data[ $i ]['font'] ) ) {
				$this->setBaseFont();
			}
			//Put the position to the right of the cell
			$this->SetXY( $x + $w, $y );
		}
		//Go to the next line
		$this->Ln( $h + 1 );
	}



}
