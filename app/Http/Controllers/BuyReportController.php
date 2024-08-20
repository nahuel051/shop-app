<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PdfService;

class BuyReportController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function index()
    {
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Obtener las compras realizadas por el usuario autenticado
        $buys = Buy::with(['details.product', 'user']) // Cargar la relación 'product.user' (vendedor)
                    ->where('user_id', $userId) // Filtrar por el usuario autenticado (comprador)
                    ->get();

        // Pasar las compras filtradas a la vista
        return view('buy.index', compact('buys'));
    }

    public function generatePdf($buyId)
    {
        // Obtener los detalles de la compra
        $buy = Buy::with(['details.product.user']) // Cargar la relación 'product.user' (vendedor)
            ->where('user_id', Auth::id()) // Asegurarse de que sea la compra del usuario autenticado
            ->findOrFail($buyId);
    
        // Preparar datos para el PDF
        $data = [
            'buy' => $buy,
            'buyer' => $buy->user, // El usuario autenticado que compró
            'details' => $buy->details,
        ];
    
        // Generar el PDF usando el servicio
        $this->pdfService->generatePdf('buy.report', $data, "nota_de_compra_{$buyId}.pdf");
    }
    
}
