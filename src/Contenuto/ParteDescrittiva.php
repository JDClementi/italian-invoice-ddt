<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 17/01/2018
 * Time: 22:19
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Contenuto;

use ItalianInvoiceDdt\Contenuto\Descrittivo\Persona;

class ParteDescrittiva {


	public $data, $numero, $Compratore, $Venditore,$Note="",$AspettoEsterioreBeni="",$Imballo="",$TipoSpedizione="",$CausaleDelTrasporto="",$Porto="",$CondizioniDiPagamento="",$DestinatarioMerce ="",$NullaOsta = '';

	/**
	 * @param string $DestinatarioMerce
	 */
	public function setDestinatarioMerce( $DestinatarioMerce ) {
		$this->DestinatarioMerce = $DestinatarioMerce;
	}

	/**
	 * @param mixed $Note
	 */
	public function setNote( $Note ) {
		$this->Note = $Note;
	}

	/**
	 * @param mixed $AspettoEsterioreBeni
	 */
	public function setAspettoEsterioreBeni( $AspettoEsterioreBeni ) {
		$this->AspettoEsterioreBeni = $AspettoEsterioreBeni;
	}

	/**
	 * @param mixed $Imballo
	 */
	public function setImballo( $Imballo ) {
		$this->Imballo = $Imballo;
	}

	/**
	 * @param mixed $TipoSpedizione
	 */
	public function setTipoSpedizione( $TipoSpedizione ) {
		$this->TipoSpedizione = $TipoSpedizione;
	}

	/**
	 * @param mixed $CausaleDelTrasporto
	 */
	public function setCausaleDelTrasporto( $CausaleDelTrasporto ) {
		$this->CausaleDelTrasporto = $CausaleDelTrasporto;
	}

	/**
	 * @param mixed $Porto
	 */
	public function setPorto( $Porto ) {
		$this->Porto = $Porto;
	}

	/**
	 * @param mixed $CondizioniDiPagamento
	 */
	public function setCondizioniDiPagamento( $CondizioniDiPagamento ) {
		$this->CondizioniDiPagamento = $CondizioniDiPagamento;
	}

	/**
	 * @param string $NullaOsta
	 */
	public function setNullaOsta( $NullaOsta ) {
		$this->NullaOsta = $NullaOsta;
	}


	public function __construct() {


	}

	/**
	 * @param mixed $data
	 */
	public function setData( $data ) {
		$this->data = $data;
	}

	/**
	 * @param mixed $numero
	 */
	public function setNumero( $numero ) {
		$this->numero = $numero;
	}


	public function setCompratore( $RappresentazionePersona = array() ) {

		$this->Compratore = new Persona( $RappresentazionePersona );

	}


	public function setVenditore( $RappresentazionePersona ) {

		$this->Venditore = new Persona( $RappresentazionePersona );

	}





}