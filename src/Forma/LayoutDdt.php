<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 22/01/2018
 * Time: 16:48
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Forma;


class LayoutDdt extends Pdf {


	public $Venditore, $Compratore;


	static $MargineSinistro = 10;
	static $MargineDestro = 200;


	/**
	 * TABELLA PRE DETTAGLI.
	 */
	static $MargineSuperiorePreDettagli = 65;
	static $AltezzaRighePreDettagli = 10;

	static $LarghezzaCodiceCliente = 30;
	static $LarghezzaPorto = 67;
	static $LarghezzaTelefono = 30;
	static $LarghezzaNumeroDdt = 30;
	static $LarghezzaDataDdt = 22;
	static $LarghezzaPag = 11;


	static $LarghezzaCondizioniDiPagamento = 97;
	static $LarghezzaValuta = 16;
	static $LarghezzaPartitaIva = 37;
	static $larghezzaCodiceFiscale = 40;


	public $MargineSinistroCodiceCliente,
		$MargineSinistroPorto,
		$MargineSinistroTelefono,
		$MargineSinistroNumeroDdt,
		$MargineSinistroDataDdt,
		$MargineSinistroPag,
		$MargineSinistroCondizioniDiPagamento,
		$MargineSinistroValuta,
		$MargineSinistroPartitaIva,
		$MargineSinistroCodiceFiscale;


	/**
	 * TABELLA DETTAGLI.
	 */

	static $LarghezzaCodice = 37,
		$LarghezzaCausale = 14,
		$LarghezzaDescrizione = 62,
		$LarghezzaQuantita = 15,
		$LarghezzaPrezzoUnitario = 26,
		$LarghezzaSconto = 9,
		$LarghezzaImporto = 18,
		$LarghezzaIva = 9,
		$AltezzaIntestazioneTabellaDettagli = 7,
		$AltezzaTabellaDettagli = 105;


	public $QuotaSuperioreIntestazioneTabellaDettagli,
		$QuotaSuperioreStampaTabellaDettagli,
		$QuotaInferioreStampaTabellaDettagli,
		$MargineSinistroCodice,
		$MargineSinistroCausale,
		$MargineSinistroDescrizione,
		$MargineSinistroQuantita,
		$MargineSinistroPrezzoUnitario,
		$MargineSinistroSconto,
		$MargineSinistroImporto,
		$MargineSinistroIva;


	/**
	 * TABELLA POST DETTAGLI.
	 */

	static $AltezzaPrimaRigaTabellaPostDettagli = 30,
		$AltezzaSecondaRigaTabellaPostDettagli = 10,
		$AltezzaTerzaRigaTabellaPostDettagli = 10,
		$AltezzaQuartaRigaTabellaPostDettagli = 15,
		$AltezzaQuintaRigaTabellaPostDettagli = 13,
		$LarghezzaInformazioniAggiuntive = 190,
		$LarghezzaCausaleDelTrasporto = 190,
		$LarghezzaTipoSpedizione = 63,
		$LarghezzaImballo = 64,
		$LarghezzaAspettoEsterioreBeni = 63,
		$LarghezzaDestinatarioDellaMerce = 190,
		$LarghezzaNote = 190;

	public $QuotaSuperioreTabellaPostDettagli,
		$QuotaInferioreTabellaPostDettagli,
		$QuotaSuperiorePrimaRigaTabellaPostDettagli,
		$QuotaSuperioreSecondaRigaTabellaPostDettagli,
		$QuotaSuperioreTerzaRigaTabellaPostDettagli,
		$QuotaSuperioreQuartaRigaTabellaPostDettagli,
		$QuotaSuperioreQuintaRigaTabellaPostDettagli,
		$MargineSinistroInformazioniAggiuntive,
		$MargineSinistroCausaleDelTrasporto,
		$MargineSinistroTipoSpedizione,
		$MargineSinistroImballo,
		$MargineSinistroAspettoEsterioreBeni,
		$MargineSinistroDestintarioDellaMerce,
		$MargineSinistroNote;


	function __construct( $Venditore, $Compratore ) {
		parent::__construct( 'P', 'mm', array( 210, 297 ), array( 'family' => 'Arial', 'style' => '', 'size' => 10 ) );


		$this->Venditore = $Venditore;

		$this->Compratore = $Compratore;


		/**
		 * TABELLA PRE DETTAGLI.
		 */
		$this->MargineSinistroCodiceCliente = self::$MargineSinistro;
		$this->MargineSinistroPorto         = $this->MargineSinistroCodiceCliente + self::$LarghezzaCodiceCliente;
		$this->MargineSinistroTelefono      = $this->MargineSinistroPorto + self::$LarghezzaPorto;
		$this->MargineSinistroNumeroDdt     = $this->MargineSinistroTelefono + self::$LarghezzaTelefono;
		$this->MargineSinistroDataDdt       = $this->MargineSinistroNumeroDdt + self::$LarghezzaNumeroDdt;
		$this->MargineSinistroPag           = $this->MargineSinistroDataDdt + self::$LarghezzaDataDdt;


		$this->MargineSinistroCondizioniDiPagamento = self::$MargineSinistro;
		$this->MargineSinistroValuta                = $this->MargineSinistroCondizioniDiPagamento + self::$LarghezzaCondizioniDiPagamento;
		$this->MargineSinistroPartitaIva            = $this->MargineSinistroValuta + self::$LarghezzaValuta;
		$this->MargineSinistroCodiceFiscale         = $this->MargineSinistroPartitaIva + self::$LarghezzaPartitaIva;
		/**
		 * TABELLA DETTAGLI.
		 */


		$this->MargineSinistroCodice         = self::$MargineSinistro;
		$this->MargineSinistroCausale        = $this->MargineSinistroCodice + self::$LarghezzaCodice;
		$this->MargineSinistroDescrizione    = $this->MargineSinistroCausale + self::$LarghezzaCausale;
		$this->MargineSinistroQuantita       = $this->MargineSinistroDescrizione + self::$LarghezzaDescrizione;
		$this->MargineSinistroPrezzoUnitario = $this->MargineSinistroQuantita + self::$LarghezzaQuantita;
		$this->MargineSinistroSconto         = $this->MargineSinistroPrezzoUnitario + self::$LarghezzaPrezzoUnitario;
		$this->MargineSinistroImporto        = $this->MargineSinistroSconto + self::$LarghezzaSconto;
		$this->MargineSinistroIva            = $this->MargineSinistroImporto + self::$LarghezzaImporto;


		$this->QuotaSuperioreIntestazioneTabellaDettagli = self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli * 2 + 2;
		$this->QuotaSuperioreStampaTabellaDettagli       = $this->QuotaSuperioreIntestazioneTabellaDettagli + self::$AltezzaIntestazioneTabellaDettagli;
		$this->QuotaInferioreStampaTabellaDettagli       = $this->QuotaSuperioreStampaTabellaDettagli + self::$AltezzaTabellaDettagli;

		/**
		 * TABELLA POST DETTAGLI.
		 */
		$this->QuotaSuperioreTabellaPostDettagli = $this->QuotaInferioreStampaTabellaDettagli + 2;

		$this->QuotaSuperiorePrimaRigaTabellaPostDettagli   = $this->QuotaSuperioreTabellaPostDettagli;
		$this->QuotaSuperioreSecondaRigaTabellaPostDettagli = $this->QuotaSuperiorePrimaRigaTabellaPostDettagli + self::$AltezzaPrimaRigaTabellaPostDettagli;
		$this->QuotaSuperioreTerzaRigaTabellaPostDettagli   = $this->QuotaSuperioreSecondaRigaTabellaPostDettagli + self::$AltezzaSecondaRigaTabellaPostDettagli;
		$this->QuotaSuperioreQuartaRigaTabellaPostDettagli  = $this->QuotaSuperioreTerzaRigaTabellaPostDettagli + self::$AltezzaTerzaRigaTabellaPostDettagli;
		$this->QuotaSuperioreQuintaRigaTabellaPostDettagli  = $this->QuotaSuperioreQuartaRigaTabellaPostDettagli + self::$AltezzaQuartaRigaTabellaPostDettagli;

		$this->QuotaInferioreTabellaPostDettagli = $this->QuotaSuperioreQuintaRigaTabellaPostDettagli + self::$AltezzaQuintaRigaTabellaPostDettagli;


		$this->MargineSinistroInformazioniAggiuntive = self::$MargineSinistro;
		$this->MargineSinistroCausaleDelTrasporto    = self::$MargineSinistro;
		$this->MargineSinistroTipoSpedizione         = self::$MargineSinistro;
		$this->MargineSinistroImballo                = $this->MargineSinistroTipoSpedizione + self::$LarghezzaTipoSpedizione;
		$this->MargineSinistroAspettoEsterioreBeni   = $this->MargineSinistroImballo + self::$LarghezzaImballo;
		$this->MargineSinistroDestintarioDellaMerce  = self::$MargineSinistro;
		$this->MargineSinistroNote                   = self::$MargineSinistro;


	}

	function Header() {

		$this->PrintDatiPersone( $this->Venditore, 10, 15, 'V' );

		$this->PrintDatiPersone( $this->Compratore, 120, 25, 'C' );


		self::PrintTabellaPreDettagli();

		self::PrintTabellaDettagli();

		self::PrintTabellaPostDettagli();

		self::StampaCampiDescrittivi();
	}

	public function PrintTabellaPreDettagli() {


		//Stampo le righe orizzontali.

		$this->Line( self::$MargineSinistro, self::$MargineSuperiorePreDettagli, self::$MargineDestro, self::$MargineSuperiorePreDettagli );
		$this->Line( self::$MargineSinistro, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli, self::$MargineDestro, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		$this->Line( self::$MargineSinistro, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli * 2, self::$MargineDestro, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli * 2 );


		//Stampo le righe verticali.
		$this->Line( self::$MargineSinistro, self::$MargineSuperiorePreDettagli, self::$MargineSinistro, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli * 2 );
		$this->Line( self::$MargineDestro, self::$MargineSuperiorePreDettagli, self::$MargineDestro, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli * 2 );

		//Prima Row.
		$this->Line( $this->MargineSinistroPorto, self::$MargineSuperiorePreDettagli, $this->MargineSinistroPorto, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		$this->Line( $this->MargineSinistroTelefono, self::$MargineSuperiorePreDettagli, $this->MargineSinistroTelefono, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		$this->Line( $this->MargineSinistroNumeroDdt, self::$MargineSuperiorePreDettagli, $this->MargineSinistroNumeroDdt, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		$this->Line( $this->MargineSinistroDataDdt, self::$MargineSuperiorePreDettagli, $this->MargineSinistroDataDdt, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		$this->Line( $this->MargineSinistroPag, self::$MargineSuperiorePreDettagli, $this->MargineSinistroPag, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		//Seconda Row.


		$this->Line( $this->MargineSinistroValuta, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli, $this->MargineSinistroValuta, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli * 2 );
		$this->Line( $this->MargineSinistroPartitaIva, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli, $this->MargineSinistroPartitaIva, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli * 2 );
		$this->Line( $this->MargineSinistroCodiceFiscale, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli, $this->MargineSinistroCodiceFiscale, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli * 2 );


		//Intestazioni.
		$this->SetFont( 'Arial', '', 7 );

		//PRIMA RIGA.

		$this->SetXY( self::$MargineSinistro, self::$MargineSuperiorePreDettagli );
		$this->Cell( self::$LarghezzaCodiceCliente, self::$AltezzaRighePreDettagli / 2, 'CODICE CLIENTE', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroPorto, self::$MargineSuperiorePreDettagli );
		$this->Cell( self::$LarghezzaPorto, self::$AltezzaRighePreDettagli / 2, 'PORTO', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroTelefono, self::$MargineSuperiorePreDettagli );
		$this->Cell( self::$LarghezzaTelefono, self::$AltezzaRighePreDettagli / 2, 'TELEFONO', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroNumeroDdt, self::$MargineSuperiorePreDettagli );
		$this->Cell( self::$LarghezzaNumeroDdt, self::$AltezzaRighePreDettagli / 2, 'NUMERO Ddt', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroDataDdt, self::$MargineSuperiorePreDettagli );
		$this->Cell( self::$LarghezzaDataDdt, self::$AltezzaRighePreDettagli / 2, 'DATA Ddt', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroPag, self::$MargineSuperiorePreDettagli );
		$this->Cell( self::$LarghezzaPag, self::$AltezzaRighePreDettagli / 2, 'PAG.', 0, 0, "L", false );
		$this->SetFont( 'Arial', 'B', 7 );
		$this->SetXY( $this->MargineSinistroPag, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$LarghezzaPag, self::$AltezzaRighePreDettagli / 2,  "    ".$this->PageNo() . '/{nb}', 0, 0, "C", false );
		$this->SetFont( 'Arial', '', 7 );

		//SECONDA RIGA.

		$this->SetXY( self::$MargineSinistro, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		$this->Cell( self::$LarghezzaCondizioniDiPagamento, self::$AltezzaRighePreDettagli / 2, 'CONDIZIONI DI PAGAMENTO', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroValuta, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		$this->Cell( self::$LarghezzaValuta, self::$AltezzaRighePreDettagli / 2, 'VALUTA', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroPartitaIva, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		$this->Cell( self::$LarghezzaPartitaIva, self::$AltezzaRighePreDettagli / 2, 'PARTITA IVA', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroCodiceFiscale, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli );
		$this->Cell( self::$larghezzaCodiceFiscale, self::$AltezzaRighePreDettagli / 2, 'CODICE FISCALE', 0, 0, "L", false );


	}

	public function PrintTabellaDettagli() {


		//Stampo le righe orizzontali.
		$this->Line( self::$MargineSinistro, $this->QuotaSuperioreIntestazioneTabellaDettagli, self::$MargineDestro, $this->QuotaSuperioreIntestazioneTabellaDettagli );

		$this->Line( self::$MargineSinistro, $this->QuotaSuperioreStampaTabellaDettagli, self::$MargineDestro, $this->QuotaSuperioreStampaTabellaDettagli );
		$this->Line( self::$MargineSinistro, $this->QuotaInferioreStampaTabellaDettagli, self::$MargineDestro, $this->QuotaInferioreStampaTabellaDettagli );


		//Stampo le righe verticali.

		$this->Line( self::$MargineSinistro, $this->QuotaSuperioreIntestazioneTabellaDettagli, self::$MargineSinistro, $this->QuotaInferioreStampaTabellaDettagli );
		$this->Line( $this->MargineSinistroCausale, $this->QuotaSuperioreIntestazioneTabellaDettagli, $this->MargineSinistroCausale, $this->QuotaInferioreStampaTabellaDettagli );
		$this->Line( $this->MargineSinistroDescrizione, $this->QuotaSuperioreIntestazioneTabellaDettagli, $this->MargineSinistroDescrizione, $this->QuotaInferioreStampaTabellaDettagli );
		$this->Line( $this->MargineSinistroQuantita, $this->QuotaSuperioreIntestazioneTabellaDettagli, $this->MargineSinistroQuantita, $this->QuotaInferioreStampaTabellaDettagli );
		$this->Line( $this->MargineSinistroPrezzoUnitario, $this->QuotaSuperioreIntestazioneTabellaDettagli, $this->MargineSinistroPrezzoUnitario, $this->QuotaInferioreStampaTabellaDettagli );
		$this->Line( $this->MargineSinistroSconto, $this->QuotaSuperioreIntestazioneTabellaDettagli, $this->MargineSinistroSconto, $this->QuotaInferioreStampaTabellaDettagli );
		$this->Line( $this->MargineSinistroImporto, $this->QuotaSuperioreIntestazioneTabellaDettagli, $this->MargineSinistroImporto, $this->QuotaInferioreStampaTabellaDettagli );
		$this->Line( $this->MargineSinistroIva, $this->QuotaSuperioreIntestazioneTabellaDettagli, $this->MargineSinistroIva, $this->QuotaInferioreStampaTabellaDettagli );
		$this->Line( self::$MargineDestro, $this->QuotaSuperioreIntestazioneTabellaDettagli, self::$MargineDestro, $this->QuotaInferioreStampaTabellaDettagli );


		//Intestazioni.
		$this->SetFont( 'Arial', '', 7 );

		$this->SetXY( self::$MargineSinistro, $this->QuotaSuperioreIntestazioneTabellaDettagli );
		$this->Cell( self::$LarghezzaCodice, self::$AltezzaIntestazioneTabellaDettagli, 'CODICE', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroCausale, $this->QuotaSuperioreIntestazioneTabellaDettagli );
		$this->Cell( self::$LarghezzaCausale, self::$AltezzaIntestazioneTabellaDettagli, 'CAUSALE', 0, 0, "C", false );

		$this->SetXY( $this->MargineSinistroDescrizione, $this->QuotaSuperioreIntestazioneTabellaDettagli );
		$this->Cell( self::$LarghezzaDescrizione, self::$AltezzaIntestazioneTabellaDettagli, 'DESCRIZIONE', 0, 0, "C", false );

		$this->SetXY( $this->MargineSinistroQuantita, $this->QuotaSuperioreIntestazioneTabellaDettagli );
		$this->Cell( self::$LarghezzaQuantita, self::$AltezzaIntestazioneTabellaDettagli, 'QUANTITA\'', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroPrezzoUnitario, $this->QuotaSuperioreIntestazioneTabellaDettagli );
		$this->Cell( self::$LarghezzaPrezzoUnitario, self::$AltezzaIntestazioneTabellaDettagli, 'PREZZO UNITARIO', 0, 0, "C", false );

		$this->SetXY( $this->MargineSinistroSconto, $this->QuotaSuperioreIntestazioneTabellaDettagli );
		$this->Cell( self::$LarghezzaSconto, self::$AltezzaIntestazioneTabellaDettagli, 'SC. %', 0, 0, "C", false );

		$this->SetXY( $this->MargineSinistroImporto, $this->QuotaSuperioreIntestazioneTabellaDettagli );
		$this->Cell( self::$LarghezzaImporto, self::$AltezzaIntestazioneTabellaDettagli, 'IMPORTO', 0, 0, "C", false );

		$this->SetXY( $this->MargineSinistroIva, $this->QuotaSuperioreIntestazioneTabellaDettagli );
		$this->Cell( self::$LarghezzaIva, self::$AltezzaIntestazioneTabellaDettagli, 'IVA', 0, 0, "C", false );


	}

	public function PrintTabellaPostDettagli() {


		//Stampo le righe orizzontali.

		$this->Line( self::$MargineSinistro, $this->QuotaSuperiorePrimaRigaTabellaPostDettagli, self::$MargineDestro, $this->QuotaSuperiorePrimaRigaTabellaPostDettagli );
		$this->Line( self::$MargineSinistro, $this->QuotaSuperioreSecondaRigaTabellaPostDettagli, self::$MargineDestro, $this->QuotaSuperioreSecondaRigaTabellaPostDettagli );
		$this->Line( self::$MargineSinistro, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli, self::$MargineDestro, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli );
		$this->Line( self::$MargineSinistro, $this->QuotaSuperioreQuartaRigaTabellaPostDettagli, self::$MargineDestro, $this->QuotaSuperioreQuartaRigaTabellaPostDettagli );
		$this->Line( self::$MargineSinistro, $this->QuotaSuperioreQuintaRigaTabellaPostDettagli, self::$MargineDestro, $this->QuotaSuperioreQuintaRigaTabellaPostDettagli );
		$this->Line( self::$MargineSinistro, $this->QuotaInferioreTabellaPostDettagli, self::$MargineDestro, $this->QuotaInferioreTabellaPostDettagli );


		//Stampo le righe verticali.

		$this->Line( self::$MargineSinistro, $this->QuotaSuperioreTabellaPostDettagli, self::$MargineSinistro, $this->QuotaInferioreTabellaPostDettagli );
		$this->Line( self::$MargineDestro, $this->QuotaSuperioreTabellaPostDettagli, self::$MargineDestro, $this->QuotaInferioreTabellaPostDettagli );


		$this->Line( $this->MargineSinistroImballo, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli, $this->MargineSinistroImballo, $this->QuotaSuperioreQuartaRigaTabellaPostDettagli );
		$this->Line( $this->MargineSinistroAspettoEsterioreBeni, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli, $this->MargineSinistroAspettoEsterioreBeni, $this->QuotaSuperioreQuartaRigaTabellaPostDettagli );

		//Intestazioni.
		$this->SetFont( 'Arial', '', 7 );

		$this->SetXY( $this->MargineSinistroInformazioniAggiuntive, $this->QuotaSuperiorePrimaRigaTabellaPostDettagli );
		$this->Cell( self::$LarghezzaInformazioniAggiuntive, 5, 'INFORMAZIONI AGGIUNTIVE', 0, 0, "L", false );


		$Margine = 15;

		$this->SetXY( $this->MargineSinistroInformazioniAggiuntive + $Margine, $this->QuotaSuperiorePrimaRigaTabellaPostDettagli + 6 );
		$this->Cell( self::GetStringWidth('NUMERO COLLI'), 4, 'NUMERO COLLI', 0, 0, "L", false );
		$this->SetXY( $this->MargineSinistroInformazioniAggiuntive + $Margine, $this->QuotaSuperiorePrimaRigaTabellaPostDettagli + 10);
		$this->Cell( self::GetStringWidth('PESO NETTO TOTALE'), 4, 'PESO NETTO TOTALE', 0, 0, "L", false );
		$this->SetXY( $this->MargineSinistroInformazioniAggiuntive + $Margine, $this->QuotaSuperiorePrimaRigaTabellaPostDettagli + 14);
		$this->Cell(self::GetStringWidth('PESO LORDO TOTALE'), 4, 'PESO LORDO TOTALE', 0, 0, "L", false );
		$this->SetXY( $this->MargineSinistroInformazioniAggiuntive + $Margine, $this->QuotaSuperiorePrimaRigaTabellaPostDettagli + 18);
		$this->Cell( self::GetStringWidth('DATA INIZIO TRASPORTO'), 4, 'DATA INIZIO TRASPORTO', 0, 0, "L", false );
		$this->SetXY( $this->MargineSinistroInformazioniAggiuntive + $Margine, $this->QuotaSuperiorePrimaRigaTabellaPostDettagli + 22);
		$this->Cell( self::GetStringWidth('ORA INIZIO TRASPORTO'), 4, 'ORA INIZIO TRASPORTO', 0, 0, "L", false );


		$this->SetXY( $this->MargineSinistroCausaleDelTrasporto, $this->QuotaSuperioreSecondaRigaTabellaPostDettagli );
		$this->Cell( self::$LarghezzaCausale, 5, 'CAUSALE DEL TRASPORTO', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroTipoSpedizione, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli );
		$this->Cell( self::$LarghezzaDescrizione, 5, 'TIPO SPEDIZIONE', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroImballo, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli );
		$this->Cell( self::$LarghezzaQuantita, 5, 'IMBALLO', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroAspettoEsterioreBeni, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli );
		$this->Cell( self::$LarghezzaPrezzoUnitario, 5, 'ASPETTO ESTERIORE BENI', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroDestintarioDellaMerce, $this->QuotaSuperioreQuartaRigaTabellaPostDettagli );
		$this->Cell( self::GetStringWidth('DESTINATARIO DELLA MERCE      '), 5, 'DESTINATARIO DELLA MERCE      ', 0, 0, "L", false );
		$this->SetFont( 'Arial', 'I', 7 );
		$this->Cell( self::GetStringWidth('(SE DIVERSO DALL\'INTESTATARIO)'), 5, '(SE DIVERSO DALL\'INTESTATARIO)', 0, 0, "L", false );
		$this->SetFont( 'Arial', '', 7 );
		$this->SetXY( $this->MargineSinistroNote, $this->QuotaSuperioreQuintaRigaTabellaPostDettagli );
		$this->Cell( self::$LarghezzaNote, 5, 'NOTE', 0, 0, "L", false );

		$this->SetXY( $this->MargineSinistroNote, $this->QuotaSuperioreQuintaRigaTabellaPostDettagli + 20);
		$this->Cell( self::$LarghezzaNote/2, 5, 'Firma (per uso interno) ___________________________________', 0, 0, "L", false );
		$this->SetXY( $this->MargineSinistroNote + self::$LarghezzaNote/2, $this->QuotaSuperioreQuintaRigaTabellaPostDettagli + 20);
		$this->Cell( self::$LarghezzaNote/2, 5, 'Firma per accettazione merce ___________________________________', 0, 0, "L", false );
	}

	public function StampaCampiDescrittivi() {
		$this->SetFont( 'Arial', 'B', 7 );
		//Codice Cliente
		$this->SetXY( self::$MargineSinistro, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$LarghezzaCodiceCliente, self::$AltezzaRighePreDettagli / 2, $this->ParteDescrittiva->Compratore->CodiceCliente, 0, 0, "L", false );
		//Porto
		$this->SetXY( $this->MargineSinistroPorto, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$LarghezzaPorto, self::$AltezzaRighePreDettagli / 2, $this->ParteDescrittiva->Porto, 0, 0, "L", false );
		//Telefono
		$this->SetXY( $this->MargineSinistroTelefono, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$LarghezzaTelefono, self::$AltezzaRighePreDettagli / 2, $this->ParteDescrittiva->Compratore->Telefono, 0, 0, "L", false );
		//Numero Ddt
		$this->SetXY( $this->MargineSinistroNumeroDdt, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$LarghezzaNumeroDdt, self::$AltezzaRighePreDettagli / 2, $this->ParteDescrittiva->numero, 0, 0, "R", false );
		//Data Ddt
		$this->SetXY( $this->MargineSinistroDataDdt, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$LarghezzaDataDdt, self::$AltezzaRighePreDettagli / 2, $this->ParteDescrittiva->data, 0, 0, "R", false );
		//Condizioni Di Pagamento
		$this->SetXY( self::$MargineSinistro, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$LarghezzaCondizioniDiPagamento, self::$AltezzaRighePreDettagli / 2, $this->ParteDescrittiva->CondizioniDiPagamento, 0, 0, "L", false );
		//Valuta
		$this->SetXY( $this->MargineSinistroValuta, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$LarghezzaValuta, self::$AltezzaRighePreDettagli / 2, 'EURO', 0, 0, "L", false );
		//PartitaIva
		$this->SetXY( $this->MargineSinistroPartitaIva, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$LarghezzaPartitaIva, self::$AltezzaRighePreDettagli / 2, $this->ParteDescrittiva->Compratore->Piva, 0, 0, "L", false );
		//Codice Fiscale
		$this->SetXY( $this->MargineSinistroCodiceFiscale, self::$MargineSuperiorePreDettagli + self::$AltezzaRighePreDettagli + self::$AltezzaRighePreDettagli / 2 );
		$this->Cell( self::$larghezzaCodiceFiscale, self::$AltezzaRighePreDettagli / 2, $this->ParteDescrittiva->Compratore->CodiceFiscale, 0, 0, "L", false );
		//Causale Del Trasporto
		$this->SetXY( $this->MargineSinistroCausaleDelTrasporto, $this->QuotaSuperioreSecondaRigaTabellaPostDettagli + 5 );
		$this->Cell( self::$LarghezzaCausale, 5, $this->ParteDescrittiva->CausaleDelTrasporto, 0, 0, "L", false );
		//Tipo Spedizione
		$this->SetXY( $this->MargineSinistroTipoSpedizione, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli + 5 );
		$this->Cell( self::$LarghezzaDescrizione, 5, $this->ParteDescrittiva->TipoSpedizione, 0, 0, "L", false );
		//Imballo
		$this->SetXY( $this->MargineSinistroImballo, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli + 5 );
		$this->Cell( self::$LarghezzaQuantita, 5, $this->ParteDescrittiva->Imballo, 0, 0, "L", false );
		//Aspetto Esteriore Beni
		$this->SetXY( $this->MargineSinistroAspettoEsterioreBeni, $this->QuotaSuperioreTerzaRigaTabellaPostDettagli + 5 );
		$this->Cell( self::$LarghezzaPrezzoUnitario, 5, $this->ParteDescrittiva->AspettoEsterioreBeni, 0, 0, "L", false );
		//Destinatario Della Merce
		$this->SetXY( $this->MargineSinistroDestintarioDellaMerce, $this->QuotaSuperioreQuartaRigaTabellaPostDettagli + 5 );
		$this->Cell( 0, 5, $this->ParteDescrittiva->DestinatarioMerce, 0, 0, "L", false );
		//Note
		$this->SetFont( 'Arial', '', 7 );
		$this->SetXY( $this->MargineSinistroNote, $this->QuotaSuperioreQuintaRigaTabellaPostDettagli + 5);
		$this->Cell(self::$LarghezzaNote, 5, $this->ParteDescrittiva->Note, 0, 0, "L", false );

	}

}