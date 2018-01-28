<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 18/01/2018
 * Time: 12:11
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Forma;


class LayoutFattura extends Pdf {


	public $Venditore, $Compratore;


	//Definisco le varie altezze di riferimento.


	static $AltezzaTabellaDettagli = 13;
	static $AltezzaCastelletto = 13;
	static $AltezzaTotali = 13;

	//Definisco i margini di stampa per i vari blocchi.

	/**
	 * Tabella Dettagli.
	 */

	static $MargineSinistroTabellaDettagli = 10;
	static $MargineDestroTabellaDettagli = 200;
	static $MargineSuperioreTabellaDettagli = 88;
	static $MargineInferioreTabellaDettagli = 210;

	//Definisco le larghezze delle colonne.


	static $MargineSuperioreDettagli = 80;

	static $LarghezzaNumero = 20;
	static $MargineSinistroNumero = 7;
	static $LarghezzaDatiNumero = 40;
	static $MargineSinistroDatiNumero = 35;

	static $LarghezzaData = 15;
	static $MargineSinistroData = 75;
	static $LarghezzaDatiData = 30;
	static $MargineSinistroDatiData = 100;


	static $LarghezzaDataDdt = 17;
	static $LarghezzaNumeroDdt = 17;
	static $LarghezzaCodiceArticolo = 21;
	static $LarghezzaDescrizione = 63;
	static $LarghezzaQuantita = 15;
	static $LarghezzaPrezzoUnitario = 23;
	static $LarghezzaSconto = 7;
	static $LarghezzaImporto = 18;
	static $LarghezzaCodiceIva = 9;


	public $MargineSinistroDataDdt
	, $MargineSinistroNumeroDdt
	, $MargineSinistroCodiceArticolo
	, $MargineSinistroDescrizione
	, $MargineSinistroQuantita
	, $MargineSinistroPrezzoUnitario
	, $MargineSinistroSconto
	, $MargineSinistroImporto
	, $MargineSinistroCodiceIva;


	/**
	 * Tabella Castelletto.
	 */
	static $MargineSinistroCastelletto = 10;
	static $MargineDestroCastelletto = 200;

	static $LarghezzaImponibileCastelletto = 25;
	static $LarghezzaCodiceIvaCastelletto = 17;
	static $LarghezzaDescrizioneCodiceCastelletto = 91;
	static $LarghezzaImpostaCastelletto = 30;
	static $LarghezzaTotaleCastelletto = 27;


	public $MargineSinistroImponibileCastelletto
	, $MargineSinistroCodiceIvaCastelletto
	, $MargineSinistroDescrizioneCodiceCastelletto
	, $MargineSinistroImpostaCastelletto
	, $MargineSinistroTotaleCastelletto;

	/**
	 * Tabella Totali.
	 *
	 */

	static $MargineSinistroTotali = 143;
	static $MargineDestroTotali = 200;

	public $QuotaTotaleImponibile = 240,
		$QuotaTotaleIva = 245,
		$QuotaTotaleFattura = 250,
		$QuotaTotaleAcconti = 255,
		$QuotaTotaleAbbuoni = 260,
		$QuotaTotaleAPagare = 265;


	public function __construct( $Venditore, $Compratore ) {

		parent::__construct( 'P', 'mm', array( 210, 297 ), array( 'family' => 'Arial', 'style' => '', 'size' => 10 ) );

		$this->Venditore = $Venditore;

		$this->Compratore = $Compratore;

		$this->MargineSinistroDataDdt        = self::$MargineSinistroTabellaDettagli;
		$this->MargineSinistroNumeroDdt      = $this->MargineSinistroDataDdt + self::$LarghezzaDataDdt;
		$this->MargineSinistroCodiceArticolo = $this->MargineSinistroNumeroDdt + self::$LarghezzaNumeroDdt;
		$this->MargineSinistroDescrizione    = $this->MargineSinistroCodiceArticolo + self::$LarghezzaCodiceArticolo;
		$this->MargineSinistroQuantita       = $this->MargineSinistroDescrizione + self::$LarghezzaDescrizione;
		$this->MargineSinistroPrezzoUnitario = $this->MargineSinistroQuantita + self::$LarghezzaQuantita;
		$this->MargineSinistroSconto         = $this->MargineSinistroPrezzoUnitario + self::$LarghezzaPrezzoUnitario;
		$this->MargineSinistroImporto        = $this->MargineSinistroSconto + self::$LarghezzaSconto;
		$this->MargineSinistroCodiceIva      = $this->MargineSinistroImporto + self::$LarghezzaImporto;


		$this->MargineSinistroImponibileCastelletto        = self::$MargineSinistroCastelletto;
		$this->MargineSinistroCodiceIvaCastelletto         = $this->MargineSinistroImponibileCastelletto + self::$LarghezzaImponibileCastelletto;
		$this->MargineSinistroDescrizioneCodiceCastelletto = $this->MargineSinistroCodiceIvaCastelletto + self::$LarghezzaCodiceIvaCastelletto;
		$this->MargineSinistroImpostaCastelletto           = $this->MargineSinistroDescrizioneCodiceCastelletto + self::$LarghezzaDescrizioneCodiceCastelletto;
		$this->MargineSinistroTotaleCastelletto            = $this->MargineSinistroImpostaCastelletto + self::$LarghezzaImpostaCastelletto;


	}

	function Header() {

		$this->PrintDatiPersone( $this->Venditore, 10, 26.5, 'V' );

		$this->PrintDatiPersone( $this->Compratore, 120, 36.5, 'C' );

		self::PrintTabellaDettagli();

		self::PrintCastelletto();

		self::PrintTotali();
	}


	public function PrintTabellaDettagli() {

		//Testa della tabella
		$this->Rect( self::$MargineSinistroTabellaDettagli, 80, self::$MargineDestroTabellaDettagli - self::$MargineSinistroTabellaDettagli, 8 );


		//Non uso Rect() in quanto renderizza male la sovrapposizione di linee sul browser quindi uso Line().


		//Orizzontali (Dall'alto al Basso)


		$this->Line( self::$MargineSinistroTabellaDettagli, self::$MargineSuperioreTabellaDettagli + 6, self::$MargineSinistroTabellaDettagli + self::$LarghezzaDataDdt + self::$LarghezzaNumeroDdt, self::$MargineSuperioreTabellaDettagli + 6 );

		$this->Line( self::$MargineSinistroTabellaDettagli, self::$MargineSuperioreTabellaDettagli + 12, self::$MargineDestroTabellaDettagli, self::$MargineSuperioreTabellaDettagli + 12 );

		$this->Line( self::$MargineSinistroTabellaDettagli, self::$MargineInferioreTabellaDettagli, self::$MargineDestroTabellaDettagli, self::$MargineInferioreTabellaDettagli );

		//Verticali (Da sinistra a destra)

		//#1
		$this->Line( $this->MargineSinistroDataDdt, self::$MargineSuperioreTabellaDettagli, $this->MargineSinistroDataDdt, self::$MargineInferioreTabellaDettagli );
		//#2
		$this->Line( $this->MargineSinistroNumeroDdt, self::$MargineSuperioreTabellaDettagli + 6, $this->MargineSinistroNumeroDdt, self::$MargineInferioreTabellaDettagli );
		//#3
		$this->Line( $this->MargineSinistroCodiceArticolo, self::$MargineSuperioreTabellaDettagli, $this->MargineSinistroCodiceArticolo, self::$MargineInferioreTabellaDettagli );
		//#4
		$this->Line( $this->MargineSinistroDescrizione, self::$MargineSuperioreTabellaDettagli, $this->MargineSinistroDescrizione, self::$MargineInferioreTabellaDettagli );
		//#5
		$this->Line( $this->MargineSinistroQuantita, self::$MargineSuperioreTabellaDettagli, $this->MargineSinistroQuantita, self::$MargineInferioreTabellaDettagli );
		//#6
		$this->Line( $this->MargineSinistroPrezzoUnitario, self::$MargineSuperioreTabellaDettagli, $this->MargineSinistroPrezzoUnitario, self::$MargineInferioreTabellaDettagli );
		//#7
		$this->Line( $this->MargineSinistroSconto, self::$MargineSuperioreTabellaDettagli, $this->MargineSinistroSconto, self::$MargineInferioreTabellaDettagli );
		//#8
		$this->Line( $this->MargineSinistroImporto, self::$MargineSuperioreTabellaDettagli, $this->MargineSinistroImporto, self::$MargineInferioreTabellaDettagli );
		//#9
		$this->Line( $this->MargineSinistroCodiceIva, self::$MargineSuperioreTabellaDettagli, $this->MargineSinistroCodiceIva, self::$MargineInferioreTabellaDettagli );
		//#10
		$this->Line( self::$MargineDestroTabellaDettagli, self::$MargineSuperioreTabellaDettagli, self::$MargineDestroTabellaDettagli, self::$MargineInferioreTabellaDettagli );


		$this->SetFont( 'Arial', '', 7 );


		//Stampo i testi del Layout.


		$this->SetXY( self::$MargineSinistroTabellaDettagli + self::$MargineSinistroNumero, self::$MargineSuperioreDettagli );
		$this->Cell( self::$LarghezzaNumero, 8, 'NUMERO:', 0, 1, 'C', false );
		$this->SetXY( self::$MargineSinistroTabellaDettagli + self::$MargineSinistroData, self::$MargineSuperioreDettagli );
		$this->Cell( self::$LarghezzaData, 8, 'DATA:', 0, 1, 'C', false );
		$this->SetXY( 178, self::$MargineSuperioreDettagli );
		$this->Cell( $this::GetStringWidth( 'Pagina' ), 8, 'Pagina', 0, 1, 'C', false );
		$this->SetXY( 192, self::$MargineSuperioreDettagli );
		$this->Cell( 0, 8, $this->PageNo() . '/{nb}', 0, 0, 'L' );


		$this->SetXY( self::$MargineSinistroTabellaDettagli, self::$MargineSuperioreTabellaDettagli );
		$this->Cell( 32, 6, 'D. D. T.', 0, 1, 'C', false );

		$this->SetXY( $this->MargineSinistroDataDdt, self::$MargineSuperioreTabellaDettagli + 6 );
		$this->Cell( self::$LarghezzaDataDdt, 6, 'DATA', 0, 1, 'C', false );

		$this->SetXY( $this->MargineSinistroNumeroDdt, self::$MargineSuperioreTabellaDettagli + 6 );
		$this->Cell( self::$LarghezzaNumeroDdt, 6, 'NUMERO', 0, 1, 'C', false );

		$this->SetXY( $this->MargineSinistroCodiceArticolo, self::$MargineSuperioreTabellaDettagli );
		$this->MultiCell( self::$LarghezzaCodiceArticolo, 6, "CODICE\nARTICOLO", 0, 'C', false );

		$this->SetXY( $this->MargineSinistroDescrizione, self::$MargineSuperioreTabellaDettagli );
		$this->Cell( self::$LarghezzaDescrizione, 12, 'DESCRIZIONE', 0, 1, 'C', false );

		$this->SetXY( $this->MargineSinistroQuantita, self::$MargineSuperioreTabellaDettagli );
		$this->Cell( self::$LarghezzaQuantita, 12, 'QUANTITA\'', 0, 1, 'C', false );

		$this->SetXY( $this->MargineSinistroPrezzoUnitario, self::$MargineSuperioreTabellaDettagli );
		$this->MultiCell( self::$LarghezzaPrezzoUnitario, 6, 'PREZZO UNITARIO', 0, 'C', false );

		$this->SetXY( $this->MargineSinistroSconto, self::$MargineSuperioreTabellaDettagli );
		$this->MultiCell( self::$LarghezzaSconto, 6, "SC.\n%", 0, 'C', false );

		$this->SetXY( $this->MargineSinistroImporto, self::$MargineSuperioreTabellaDettagli );
		$this->Cell( self::$LarghezzaImporto, 12, 'IMPORTO', 0, 1, 'C', false );

		$this->SetXY( $this->MargineSinistroCodiceIva, self::$MargineSuperioreTabellaDettagli );
		$this->MultiCell( self::$LarghezzaCodiceIva, 6, "COD.\nIVA", 0, 'C', false );


	}

	public function PrintCastelletto() {


		//Stampo le linee orizzontali del "castelletto".

		$NumeroRigheCastelletto = 6;

		$n = 1;

		while ( $n <= $NumeroRigheCastelletto ) {

			$this->Line( self::$MargineSinistroCastelletto, self::$MargineInferioreTabellaDettagli + $n * 5, self::$MargineDestroCastelletto, self::$MargineInferioreTabellaDettagli + $n * 5 );
			$n ++;

		}

		$MargineInferiore = self::$MargineInferioreTabellaDettagli + $NumeroRigheCastelletto * 5;


		$this->Line( self::$MargineSinistroCastelletto, self::$MargineInferioreTabellaDettagli, self::$MargineSinistroCastelletto, $MargineInferiore );
		$this->Line( $this->MargineSinistroCodiceIvaCastelletto, self::$MargineInferioreTabellaDettagli, $this->MargineSinistroCodiceIvaCastelletto, $MargineInferiore );
		$this->Line( $this->MargineSinistroDescrizioneCodiceCastelletto, self::$MargineInferioreTabellaDettagli, $this->MargineSinistroDescrizioneCodiceCastelletto, $MargineInferiore );
		$this->Line( $this->MargineSinistroImpostaCastelletto, self::$MargineInferioreTabellaDettagli, $this->MargineSinistroImpostaCastelletto, $MargineInferiore );
		$this->Line( $this->MargineSinistroTotaleCastelletto, self::$MargineInferioreTabellaDettagli, $this->MargineSinistroTotaleCastelletto, $MargineInferiore );
		$this->Line( self::$MargineDestroCastelletto, self::$MargineInferioreTabellaDettagli, self::$MargineDestroCastelletto, $MargineInferiore );


		//Stampo le intestazioni.

		$this->SetFont( 'Arial', 'B', 7 );

		$this->SetXY( self::$MargineSinistroCastelletto, self::$MargineInferioreTabellaDettagli );
		$this->Cell( self::$LarghezzaImponibileCastelletto, 5, 'IMPONIBILE', 0, 1, 'C', false );
		$this->SetXY( $this->MargineSinistroCodiceIvaCastelletto, self::$MargineInferioreTabellaDettagli );
		$this->Cell( self::$LarghezzaCodiceIvaCastelletto, 5, 'CODICE IVA', 0, 1, 'C', false );
		$this->SetXY( $this->MargineSinistroDescrizioneCodiceCastelletto, self::$MargineInferioreTabellaDettagli );
		$this->Cell( self::$LarghezzaDescrizioneCodiceCastelletto, 5, 'DESCRIZIONE CODICE', 0, 1, 'C', false );
		$this->SetXY( $this->MargineSinistroImpostaCastelletto, self::$MargineInferioreTabellaDettagli );
		$this->Cell( self::$LarghezzaImpostaCastelletto, 5, 'IMPOSTA', 0, 1, 'C', false );
		$this->SetXY( $this->MargineSinistroTotaleCastelletto, self::$MargineInferioreTabellaDettagli );
		$this->Cell( self::$LarghezzaTotaleCastelletto, 5, 'TOTALE', 0, 1, 'C', false );


	}

	public function PrintTotali() {


		$MargineSuperiore = 240;

		//Stampo le linee orizzontali dei totali.

		$NumeroTotali = 6;

		$n = 1;

		$Quota = $MargineSuperiore;

		while ( $n <= $NumeroTotali ) {
			if ( $n === 6 ) {
				$Quota += 7;
			} else {
				$Quota += 5;
			}
			$this->Line( self::$MargineDestroTotali, $Quota, self::$MargineSinistroTotali, $Quota );
			$n ++;
		}

		//Stampo Le Linee verticali dei totali.

		$this->Line( self::$MargineSinistroTotali, $MargineSuperiore, self::$MargineSinistroTotali, $Quota );
		$this->Line( self::$MargineSinistroTotali + 30, $MargineSuperiore, self::$MargineSinistroTotali + 30, $Quota );
		$this->Line( self::$MargineDestroTotali, $MargineSuperiore, self::$MargineDestroTotali, $Quota );


		$this->SetFont( 'Arial', 'B', 7 );

		$this->SetXY( self::$MargineSinistroTotali, $MargineSuperiore );
		$this->Cell( 28, 5, 'Totale imponibile', 0, 1, 'L', false );
		$this->SetXY( self::$MargineSinistroTotali, $MargineSuperiore + 5 );
		$this->Cell( 28, 5, 'Totale IVA', 0, 1, 'L', false );
		$this->SetXY( self::$MargineSinistroTotali, $MargineSuperiore + 10 );
		$this->Cell( 28, 5, 'TOTALE FATTURA', 0, 1, 'L', false );
		$this->SetXY( self::$MargineSinistroTotali, $MargineSuperiore + 15 );
		$this->Cell( 28, 5, 'Acconti', 0, 1, 'L', false );
		$this->SetXY( self::$MargineSinistroTotali, $MargineSuperiore + 20 );
		$this->Cell( 28, 5, 'Abbuoni/Omaggi', 0, 1, 'L', false );


		$this->SetFont( 'Arial', 'B', 8 );
		$this->SetXY( self::$MargineSinistroTotali, $MargineSuperiore + 25 );
		$this->Cell( 28, 7, 'TOTALE A PAGARE', 0, 1, 'L', false );
	}



}