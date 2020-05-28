<?php
/**
 * Created by PhpStorm.
 * User: Jacopo Di Clementi
 * Date: 18/01/2018
 * Time: 12:21
 * Project: italian-invoice-ddt
 */

namespace ItalianInvoiceDdt\Documenti;

use ItalianInvoiceDdt\Forma\LayoutFattura;

class Fattura extends LayoutFattura
{

    public $Linee;

    public $Aliquote;

    public $ParteTabellare;

    public $TotaleImponibile = 0
    , $TotaleIva = 0
    , $TotaleAcconti = 0
    , $TotaleAbbuoni = 0;

    public $ParteDescrittiva;

    public function __construct($ParteDescrittiva, $ParteTabellare)
    {
        parent::__construct($ParteDescrittiva->Venditore, $ParteDescrittiva->Compratore);
        $this->Linee = $ParteTabellare->Linee;
        $this->Aliquote = $ParteTabellare->totaleAliquote;
        $this->TotaleAbbuoni = $ParteTabellare->totaleScontiTotale;

        $this->ParteTabellare = $ParteTabellare;
        $this->ParteDescrittiva = $ParteDescrittiva;
    }

    function footer()
    {
        if ($this->ParteDescrittiva->NullaOsta !== '') {
            $this->SetFont('Arial', '', 7);
            $this->SetXY(10, 280);
            $this->Cell(190, 5, $this->ParteDescrittiva->NullaOsta, 1, 0, 'C', false);
        }
    }

    public function Stampa()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->StampaCampiDescrittivi();
        $this->StampaRigheDettaglio();
        $this->StampaRigheCastelletto();
        $this->StampaRigheTotali();
        $this->Output();
    }

    public function Salva($name)
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->StampaCampiDescrittivi();
        $this->StampaRigheDettaglio();
        $this->StampaRigheCastelletto();
        $this->StampaRigheTotali();
        return $this->Output('F', $name);
    }

    public function StampaRigheDettaglio()
    {
        $this->SetXY(parent::$MargineSinistroTabellaDettagli, parent::$MargineSuperioreTabellaDettagli + 12);
        foreach ($this->Linee as $Linea) {
            $ProductsLine = array(
                array(
                    'width' => parent::$LarghezzaDataDdt,
                    'txt' => $Linea->Ddt['Data'],
                    'align' => 'C'
                ),
                array(
                    'width' => parent::$LarghezzaNumeroDdt,
                    'txt' => $Linea->Ddt['Numero'],
                    'align' => 'C'
                ),
                array(
                    'width' => parent::$LarghezzaCodiceArticolo,
                    'txt' => $Linea->CodiceArticolo,
                    'align' => 'C'
                ),
                array(
                    'width' => parent::$LarghezzaDescrizione,
                    'txt' => $Linea->Descrizione,
                    'align' => 'L'
                ),
                array(
                    'width' => parent::$LarghezzaQuantita,
                    'txt' => parent::FormattaNumero($Linea->Numero),
                    'align' => 'R'
                ),
                array(
                    'width' => parent::$LarghezzaPrezzoUnitario,
                    'txt' => parent::FormattaNumero($Linea->PrezzoUnitario),
                    'align' => 'R'
                ),
                array(
                    'width' => parent::$LarghezzaSconto,
                    'txt' => $Linea->Sconto,
                    'align' => 'C'
                ),
                array(
                    'width' => parent::$LarghezzaImporto,
                    'txt' => parent::FormattaNumero(round($Linea->Numero * $Linea->PrezzoUnitario, 2)),
                    'align' => 'R'
                ),
                array(
                    'width' => parent::$LarghezzaCodiceIva,
                    'txt' => $Linea->Iva,
                    'align' => 'C'
                ),
            );
            $this->PrintDettagliTableRow($ProductsLine, parent::$MargineSuperioreTabellaDettagli + 12, self::$MargineInferioreTabellaDettagli);
        }
    }

    public function StampaRigheCastelletto()
    {
        $this->SetXY(parent::$MargineSinistroCastelletto, self::$MargineInferioreTabellaDettagli + 5);
        $Aliquote = $this->Aliquote;
        ksort($Aliquote, SORT_NUMERIC);
        foreach ($Aliquote as $Aliquota => $Totale) {
            $Imponibile = round((100 * $Totale) / (100 + $Aliquota), 2);
            $DescrizioneCodice = "Aliq. Iva $Aliquota%";
            $Imposta = round($Totale - $Imponibile, 2);
            $this->TotaleImponibile += $Imponibile;
            $this->TotaleIva += $Imposta;
            $AliquotaLine = array(
                array(
                    'width' => parent::$LarghezzaImponibileCastelletto,
                    'txt' => parent::FormattaNumero($Imponibile),
                    'align' => 'R'
                ),
                array(
                    'width' => parent::$LarghezzaCodiceIvaCastelletto,
                    'txt' => $Aliquota,
                    'align' => 'R'
                ),
                array(
                    'width' => parent::$LarghezzaDescrizioneCodiceCastelletto,
                    'txt' => $DescrizioneCodice,
                    'align' => 'L'
                ),
                array(
                    'width' => parent::$LarghezzaImpostaCastelletto,
                    'txt' => parent::FormattaNumero($Imposta),
                    'align' => 'R'
                ),
                array(
                    'width' => parent::$LarghezzaTotaleCastelletto,
                    'txt' => parent::FormattaNumero($Totale),
                    'align' => 'R'
                )
            );
            $this->PrintCastellettoTableRow($AliquotaLine);
        }
    }

    public function StampaRigheTotali()
    {
        $this->SetFont('Arial', 'B', 7);

        $this->SetXY($this->MargineSinistroImporto, $this->QuotaTotaleImponibile);
        $this->Cell(parent::$MargineDestroTabellaDettagli - $this->MargineSinistroImporto, 5, parent::FormattaNumero($this->TotaleImponibile), 0, 0, 'R', false);

        $this->SetXY($this->MargineSinistroImporto, $this->QuotaTotaleIva);
        $this->Cell(parent::$MargineDestroTabellaDettagli - $this->MargineSinistroImporto, 5, parent::FormattaNumero($this->TotaleIva), 0, 0, 'R', false);

        $this->SetXY($this->MargineSinistroImporto, $this->QuotaTotaleAcconti);
        $this->Cell(parent::$MargineDestroTabellaDettagli - $this->MargineSinistroImporto, 5, parent::FormattaNumero($this->TotaleAcconti), 0, 0, 'R', false);

        $this->SetXY($this->MargineSinistroImporto, $this->QuotaTotaleAbbuoni);
        $this->Cell(parent::$MargineDestroTabellaDettagli - $this->MargineSinistroImporto, 5, parent::FormattaNumero($this->TotaleAbbuoni), 0, 0, 'R', false);

        $this->SetXY($this->MargineSinistroImporto, $this->QuotaTotaleFattura);
        $this->Cell(parent::$MargineDestroTabellaDettagli - $this->MargineSinistroImporto, 5, parent::FormattaNumero($this->ParteTabellare->totale), 0, 0, 'R', false);

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY($this->MargineSinistroImporto, $this->QuotaTotaleAPagare);
        $this->Cell(parent::$MargineDestroTabellaDettagli - $this->MargineSinistroImporto, 7, parent::FormattaNumero($this->ParteTabellare->totale - $this->ParteTabellare->totaleScontiTotale), 0, 0, 'R', false);
    }

    public function StampaCampiDescrittivi()
    {
        $this->SetFont('Arial', '', 7);
        $this->SetXY(parent::$MargineSinistroDatiNumero, parent::$MargineSuperioreDettagli);
        $this->Cell(parent::$LarghezzaDatiNumero, 8, $this->ParteDescrittiva->numero, 0, 0, 'L', false);
        $this->SetXY(parent::$MargineSinistroDatiData, parent::$MargineSuperioreDettagli);
        $this->Cell(parent::$LarghezzaDatiData, 8, $this->ParteDescrittiva->data, 0, 0, 'L', false);
    }

    public function PrintDettagliTableRow($data, $minHeight, $maxHeight)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($data[$i]['width'], $data[$i]['txt'], (isset($data[$i]['font']) ? $data[$i]['font'] : false)));
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        if ($this->GetY() + $h > $maxHeight) {
            $this->SetFont('Arial', 'B', 11);
            $this->SetXY($this->MargineSinistroImporto, $this->QuotaTotaleAPagare);
            $this->Cell(parent::$MargineDestroTabellaDettagli - $this->MargineSinistroImporto, 7, 'SEGUE', 0, 0, 'C', false);
            $this->AddPage($this->CurOrientation);
            $this->StampaCampiDescrittivi();
            $this->SetY($minHeight);
        }

        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $data[$i]['width'];
            $a = isset($data[$i]['align']) ? $data[$i]['align'] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            //Print the text
            $MultiCellHeight = $h / $this->NbLines($w, $data[$i]['txt']);
            if (isset($data[$i]['font'])) {
                $this->SetFont($data[$i]['font']['family'], $data[$i]['font']['style'], $data[$i]['font']['size']);
            }
            $this->MultiCell($w, $MultiCellHeight, $data[$i]['txt'], 0, $a);
            if (isset($data[$i]['font'])) {
                $this->setBaseFont();
            }
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h + 1);
    }

    public function PrintCastellettoTableRow($data)
    {

        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($data[$i]['width'], $data[$i]['txt'], (isset($data[$i]['font']) ? $data[$i]['font'] : false)));
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $data[$i]['width'];
            $a = isset($data[$i]['align']) ? $data[$i]['align'] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            //Print the text
            $MultiCellHeight = $h / $this->NbLines($w, $data[$i]['txt']);
            if (isset($data[$i]['font'])) {
                $this->SetFont($data[$i]['font']['family'], $data[$i]['font']['style'], $data[$i]['font']['size']);
            }
            $this->MultiCell($w, $MultiCellHeight, $data[$i]['txt'], 0, $a);
            if (isset($data[$i]['font'])) {
                $this->setBaseFont();
            }
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);

    }


}