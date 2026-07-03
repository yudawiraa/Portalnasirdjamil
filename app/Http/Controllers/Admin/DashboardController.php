<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'total' => Aspirasi::query()->count(),
            'received' => Aspirasi::query()->where('status', Aspirasi::STATUS_RECEIVED)->count(),
            'processing' => Aspirasi::query()->whereIn('status', [
                Aspirasi::STATUS_VERIFIED,
                Aspirasi::STATUS_IN_REVIEW,
                Aspirasi::STATUS_FOLLOW_UP,
            ])->count(),
            'completed' => Aspirasi::query()->where('status', Aspirasi::STATUS_COMPLETED)->count(),
            'needsAttention' => Aspirasi::query()->whereIn('status', [
                Aspirasi::STATUS_NEED_DATA,
                Aspirasi::STATUS_REJECTED,
            ])->count(),
            'latest' => Aspirasi::query()->with('category')->latest('submitted_at')->limit(6)->get(),
        ]);
    }
}
