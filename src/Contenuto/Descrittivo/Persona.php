<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 18/01/2018
 * Time: 14:51
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Contenuto\Descrittivo;


class Persona {


	public $Tipologia = "", $Nome = "", $Cognome = "", $RagioneSociale = "", $Piva = "", $CodiceFiscale = "", $Indirizzo = "", $CodiceCliente = "", $Telefono = "";


	public function __construct( $RappresentazionePersona = array() ) {


		if ( isset( $RappresentazionePersona['Tipologia'] ) ) {

			$this->Tipologia = $RappresentazionePersona['Tipologia'];
		}

		if ( isset( $RappresentazionePersona['Nome'] ) ) {

			$this->Nome = $RappresentazionePersona['Nome'];

		}

		if ( isset( $RappresentazionePersona['Cognome'] ) ) {

			$this->Cognome = $RappresentazionePersona['Cognome'];

		}

		if ( isset( $RappresentazionePersona['RagioneSociale'] ) ) {

			$this->RagioneSociale = $RappresentazionePersona['RagioneSociale'];

		}

		if ( isset( $RappresentazionePersona['Piva'] ) ) {

			$this->Piva = $RappresentazionePersona['Piva'];

		}

		if ( isset( $RappresentazionePersona['CodiceFiscale'] ) ) {

			$this->CodiceFiscale = $RappresentazionePersona['CodiceFiscale'];

		}

		if ( isset( $RappresentazionePersona['Indirizzo'] ) ) {

			$this->Indirizzo = $RappresentazionePersona['Indirizzo'];

		}

		if ( isset( $RappresentazionePersona['CodiceCliente'] ) ) {

			$this->CodiceCliente = $RappresentazionePersona['CodiceCliente'];

		}

		if ( isset( $RappresentazionePersona['Telefono'] ) ) {

			$this->Telefono = $RappresentazionePersona['Telefono'];

		}
	}


}