<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Barryvdh\DomPDF\Facade\Pdf;

class DownloadPdfController extends Controller
{
    public function __invoke(Presupuesto $presupuesto,$order)
    {
        $record = Presupuesto::findOrFail($order);
        $archivo1 = asset("/images/".$record->archivo1);
        $pdf = Pdf::loadView('pdf', compact('record'));
        return $pdf->setPaper('a4','landscape')->stream('presupuesto-'.$record->id.'.pdf');
    }
}
