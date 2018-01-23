<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 18/01/2018
 * Time: 11:08
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Forma;

use FPDF;

class Pdf extends FPDF {

	var $BaseFont;

	function __construct(
		$orientation = 'P', $unit = 'mm', $size = array(
		210,
		297
	), $BaseFont = array( 'family' => 'Arial', 'style' => '', 'size' => 10 )
	) {

		parent::__construct( $orientation, $unit, $size );

		$this->BaseFont = $BaseFont;

	}

	/**
	 * @param $w
	 * @param $txt
	 *
	 * @return int
	 */
	public function NbLines( $w, $txt, $font = false ) {

		if ( $font !== false ) {

			$this->SetFont( $font['family'], $font['style'], $font['size'] );

		}

		//Computes the number of lines a MultiCell of width w will take
		$cw =& $this->CurrentFont['cw'];
		if ( $w == 0 ) {
			$w = $this->w - $this->rMargin - $this->x;
		}
		$wmax = ( $w - 2 * $this->cMargin ) * 1000 / $this->FontSize;
		$s    = str_replace( "\r", '', $txt );
		$nb   = strlen( $s );
		if ( $nb > 0 and $s[ $nb - 1 ] == "\n" ) {
			$nb --;
		}
		$sep = - 1;
		$i   = 0;
		$j   = 0;
		$l   = 0;
		$nl  = 1;
		while ( $i < $nb ) {
			$c = $s[ $i ];
			if ( $c == "\n" ) {
				$i ++;
				$sep = - 1;
				$j   = $i;
				$l   = 0;
				$nl ++;
				continue;
			}
			if ( $c == ' ' ) {
				$sep = $i;
			}
			$l += $cw[ $c ];
			if ( $l > $wmax ) {
				if ( $sep == - 1 ) {
					if ( $i == $j ) {
						$i ++;
					}
				} else {
					$i = $sep + 1;
				}
				$sep = - 1;
				$j   = $i;
				$l   = 0;
				$nl ++;
			} else {
				$i ++;
			}
		}

		if ( $font !== false ) {

			$this->setBaseFont();

		}

		return $nl;
	}

	public function getRowHeight( $data ) {

		$nb = 0;

		for ( $i = 0; $i < count( $data ); $i ++ ) {
			$nb = max( $nb, $this->NbLines( $data[ $i ]['width'], $data[ $i ]['txt'], ( isset( $data[ $i ]['font'] ) ? $data[ $i ]['font'] : false ) ) );
		}
		$h = 5 * $nb;

		return $h;

	}

	public function PrintTableRow( $data ) {
		//Calculate the height of the row
		$nb = 0;
		for ( $i = 0; $i < count( $data ); $i ++ ) {
			$nb = max( $nb, $this->NbLines( $data[ $i ]['width'], $data[ $i ]['txt'], ( isset( $data[ $i ]['font'] ) ? $data[ $i ]['font'] : false ) ) );
		}
		$h = 5 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak( $h );
		//Draw the cells of the row
		for ( $i = 0; $i < count( $data ); $i ++ ) {
			$w = $data[ $i ]['width'];
			$a = isset( $data[ $i ]['align'] ) ? $data[ $i ]['align'] : 'L';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			//Draw the border
			$this->Rect( $x, $y, $w, $h );
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
		$this->Ln( $h );
	}

	public function PrintDatiPersone( $Persona, $X, $Y, $Tipo ) {

		$LarghezzaRiquadro      = 80;
		$PaddingSinistroEsordio = 3;
		$PaddingSinistroDati    = 6.5;

		$LarghezzaPiva = $LarghezzaCodFis = 15;

		$LarghezzaDati = $LarghezzaRiquadro - $PaddingSinistroDati;
		$LarghezzaDatiPiva = $LarghezzaDatiCodFis = $LarghezzaDati - $LarghezzaPiva;


		$xTipologia = $X + $PaddingSinistroEsordio;
		$xDati      = $X + $PaddingSinistroDati;

		$this->SetXY( $xTipologia, $Y );
		$this->SetFont( 'Arial', 'B', 7 );

		if ( $Persona->Tipologia === 'Giuridica' ) {

			if ( $Tipo === 'V' ) {
				$this->Cell( $this::GetStringWidth( "Azienda" ), 5, "Azienda", 0, 1, 'C', false );
			} else {
				$this->Cell( $this::GetStringWidth( "Spett.le" ), 5, "Spett.le", 0, 1, 'C', false );
			}

			$this->SetFont( 'Arial', 'B', 8 );
			$this->SetX( $xDati );
			$RagioneSociale = strtoupper( $Persona->RagioneSociale );
			$this->MultiCell( $LarghezzaDati, 5, $RagioneSociale, 0, "L", false );


		} else if ( $Persona->Tipologia === 'Fisica' ) {

			$this->Cell( $this::GetStringWidth( "Gentile" ), 5, "Gentile", 0, 1, 'C', false );
			$this->SetFont( 'Arial', 'B', 8 );
			$this->SetX( $xDati );
			$NomeCompleto = strtoupper( $Persona->Nome . ' ' . $Persona->Cognome );
			$this->MultiCell( $LarghezzaDati, 5, $NomeCompleto, 0, "L", false );

		}

		$this->SetFont( 'Arial', '', 8 );

		$this->SetX( $xDati );
		$Indirizzo1 = strtoupper( $Persona->Indirizzo['Denominazione'] . " " . $Persona->Indirizzo['Nome'] . " " . $Persona->Indirizzo['Civico'] );
		$this->Cell( $LarghezzaDati, 4, $Indirizzo1, 0, 1, 'L', false );

		$this->SetX( $xDati );
		$Indirizzo2 = strtoupper( $Persona->Indirizzo['Cap'] . " " . $Persona->Indirizzo['Comune'] . " (" . $Persona->Indirizzo['Provincia'] . ")" );
		$this->Cell( $LarghezzaDati, 4, $Indirizzo2, 0, 1, 'L', false );


		$this->SetX( $xDati );
		$this->Cell( $LarghezzaPiva, 4, "P.IVA ", 0, 0, 'L', false );
		$this->Cell( $LarghezzaDatiPiva, 4, $Persona->Piva, 0, 1, 'L', false );

		$this->SetX( $xDati );
		$this->Cell( $LarghezzaCodFis, 4, "C.F.", 0, 0, 'L', false );
		$CodiceFiscale = strtoupper( $Persona->CodiceFiscale );
		$this->Cell( $LarghezzaDatiCodFis, 4, $CodiceFiscale, 0, 1, 'L', false );


		$this->Rect( $X, $Y, $LarghezzaRiquadro, $this->GetY() - $Y + 1);


	}

	public function CheckPageBreak( $h ) {
		//If the height h would cause an overflow, add a new page immediately
		if ( $this->GetY() + $h > $this->PageBreakTrigger ) {
			$this->AddPage( $this->CurOrientation );
		}
	}

	/* Stampa una cella */
	public function printTableCell( $h, $w, $txt, $border, $a, $fill = false ) {
		//Save the current position
		$x = $this->GetX();
		$y = $this->GetY();
		//Draw the border
		$this->Rect( $x, $y, $w, $h );
		//Print the text
		$this->MultiCell( $w, $h, $txt, 0, $a, $fill );
		//Put the position to the right of the cell
		$this->SetXY( $x + $w, $y );
	}

	public function setBaseFont() {
		$this->SetFont( $this->BaseFont['family'], $this->BaseFont['style'], $this->BaseFont['size'] );
	}

	public static function FormattaNumero( $Float ) {
		return number_format( $Float, 2, ',', '' );
	}

	//Funzioni per Stampare un quadrilatero con border radius.
	function RoundedRect( $x, $y, $w, $h, $r, $corners = '1234', $style = '' ) {
		$k  = $this->k;
		$hp = $this->h;
		if ( $style == 'F' ) {
			$op = 'f';
		} elseif ( $style == 'FD' || $style == 'DF' ) {
			$op = 'B';
		} else {
			$op = 'S';
		}
		$MyArc = 4 / 3 * ( sqrt( 2 ) - 1 );
		$this->_out( sprintf( '%.2F %.2F m', ( $x + $r ) * $k, ( $hp - $y ) * $k ) );

		$xc = $x + $w - $r;
		$yc = $y + $r;
		$this->_out( sprintf( '%.2F %.2F l', $xc * $k, ( $hp - $y ) * $k ) );
		if ( strpos( $corners, '2' ) === false ) {
			$this->_out( sprintf( '%.2F %.2F l', ( $x + $w ) * $k, ( $hp - $y ) * $k ) );
		} else {
			$this->_Arc( $xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc );
		}

		$xc = $x + $w - $r;
		$yc = $y + $h - $r;
		$this->_out( sprintf( '%.2F %.2F l', ( $x + $w ) * $k, ( $hp - $yc ) * $k ) );
		if ( strpos( $corners, '3' ) === false ) {
			$this->_out( sprintf( '%.2F %.2F l', ( $x + $w ) * $k, ( $hp - ( $y + $h ) ) * $k ) );
		} else {
			$this->_Arc( $xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r );
		}

		$xc = $x + $r;
		$yc = $y + $h - $r;
		$this->_out( sprintf( '%.2F %.2F l', $xc * $k, ( $hp - ( $y + $h ) ) * $k ) );
		if ( strpos( $corners, '4' ) === false ) {
			$this->_out( sprintf( '%.2F %.2F l', ( $x ) * $k, ( $hp - ( $y + $h ) ) * $k ) );
		} else {
			$this->_Arc( $xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc );
		}

		$xc = $x + $r;
		$yc = $y + $r;
		$this->_out( sprintf( '%.2F %.2F l', ( $x ) * $k, ( $hp - $yc ) * $k ) );
		if ( strpos( $corners, '1' ) === false ) {
			$this->_out( sprintf( '%.2F %.2F l', ( $x ) * $k, ( $hp - $y ) * $k ) );
			$this->_out( sprintf( '%.2F %.2F l', ( $x + $r ) * $k, ( $hp - $y ) * $k ) );
		} else {
			$this->_Arc( $xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r );
		}
		$this->_out( $op );
	}

	function _Arc( $x1, $y1, $x2, $y2, $x3, $y3 ) {
		$h = $this->h;
		$this->_out( sprintf( '%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1 * $this->k, ( $h - $y1 ) * $this->k,
			$x2 * $this->k, ( $h - $y2 ) * $this->k, $x3 * $this->k, ( $h - $y3 ) * $this->k ) );
	}

}


