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

class ParteTabellare
{

    public $Linee = array();

    public $totale = 0;

    public $totaleAliquote = array();

    public $totaleScontiTotale = 0;

    public function addLinea($Descrizione, $Numero, $PrezzoUnitario, $Iva, $CodiceArticolo = "", $Sconto = 0, $Ddt = array('Numero' => '1243', 'Data' => '13/04/2017'))
    {
        $this->Linee[] = new Linea($Descrizione, $Numero, $PrezzoUnitario, $Iva, $CodiceArticolo, $Sconto, $Ddt);
        $PrezzoRiga = round($Numero * $PrezzoUnitario, 2);
        $this->totale += $PrezzoRiga;
        if (!isset($this->totaleAliquote[$Iva])) {
            $this->totaleAliquote[$Iva] = $PrezzoRiga;
        } else {
            $this->totaleAliquote[$Iva] += $PrezzoRiga;
        }
    }

    /**
     * @return int
     */
    public function getTotale()
    {
        return $this->totale;
    }

    public function addScontoTotale($value)
    {
        $this->totaleScontiTotale += $value;
    }


}