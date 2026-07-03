<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingAspirasiController extends Controller
{
    public function form(): View
    {
        return view('aspirasi.track', [
            'aspirasi' => null,
            'notFound' => false,
        ]);
    }

    public function lookup(Request $request): View
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:30'],
            'whatsapp' => ['required', 'string', 'max:30'],
        ]);

        $aspirasi = Aspirasi::query()
            ->with(['category', 'histories'])
            ->where('code', strtoupper(trim($validated['code'])))
            ->where('whatsapp', AspirasiController::normalizeWhatsapp($validated['whatsapp']))
            ->first();

        return view('aspirasi.track', [
            'aspirasi' => $aspirasi,
            'notFound' => ! $aspirasi,
        ]);
    }
}
