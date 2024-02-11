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
        return Pdf::loadView('pdf', ['record' => $record])
            ->download('Presupuesto-'.$record->id.'.pdf');
    }
}
