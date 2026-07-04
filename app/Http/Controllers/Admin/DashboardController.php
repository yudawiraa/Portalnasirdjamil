<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\AspirasiCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $filteredQuery = $this->filteredQuery($request);
        $filteredItems = (clone $filteredQuery)->with('category')->latest('submitted_at')->get();

        return view('admin.dashboard', [
            'total' => Aspirasi::query()->count(),
            'filteredTotal' => $filteredItems->count(),
            'received' => $filteredItems->where('status', Aspirasi::STATUS_RECEIVED)->count(),
            'processing' => $filteredItems->whereIn('status', [
                Aspirasi::STATUS_VERIFIED,
                Aspirasi::STATUS_IN_REVIEW,
                Aspirasi::STATUS_FOLLOW_UP,
            ])->count(),
            'completed' => $filteredItems->where('status', Aspirasi::STATUS_COMPLETED)->count(),
            'needsAttention' => $filteredItems->whereIn('status', [
                Aspirasi::STATUS_NEED_DATA,
                Aspirasi::STATUS_REJECTED,
            ])->count(),
            'latest' => $filteredItems->take(8),
            'categories' => AspirasiCategory::query()->orderBy('name')->get(),
            'statuses' => Aspirasi::statuses(),
            'priorities' => Aspirasi::priorities(),
            'filters' => $request->only(['q', 'status', 'priority', 'category_id', 'city', 'date_from', 'date_to']),
            'statusStats' => $this->statusStats($filteredItems),
            'categoryStats' => $this->groupStats($filteredItems, fn (Aspirasi $item): string => $item->category?->name ?: 'Tanpa Kategori'),
            'cityStats' => $this->groupStats($filteredItems, fn (Aspirasi $item): string => $item->city ?: 'Wilayah Tidak Diisi'),
            'monthlyStats' => $this->monthlyStats($filteredItems),
        ]);
    }

    private function filteredQuery(Request $request): Builder
    {
        return Aspirasi::query()
            ->search($request->string('q')->toString())
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->status))
            ->when($request->filled('priority'), fn (Builder $query) => $query->where('priority', $request->priority))
            ->when($request->filled('category_id'), fn (Builder $query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('city'), fn (Builder $query) => $query->where('city', 'like', '%'.$request->city.'%'))
            ->when($request->filled('date_from'), fn (Builder $query) => $query->whereDate('submitted_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn (Builder $query) => $query->whereDate('submitted_at', '<=', $request->date_to));
    }

    private function statusStats(Collection $items): Collection
    {
        return collect(Aspirasi::statuses())->map(fn (array $meta, string $status): array => [
            'label' => $meta['label'],
            'total' => $items->where('status', $status)->count(),
        ])->values();
    }

    private function groupStats(Collection $items, callable $labelResolver, int $limit = 8): Collection
    {
        return $items
            ->groupBy($labelResolver)
            ->map(fn (Collection $rows, string $label): array => [
                'label' => $label,
                'total' => $rows->count(),
            ])
            ->sortByDesc('total')
            ->take($limit)
            ->values();
    }

    private function monthlyStats(Collection $items): Collection
    {
        return $items
            ->filter(fn (Aspirasi $item): bool => filled($item->submitted_at))
            ->groupBy(fn (Aspirasi $item): string => $item->submitted_at->format('Y-m'))
            ->map(fn (Collection $rows, string $period): array => [
                'label' => Carbon::createFromFormat('Y-m', $period)->translatedFormat('M Y'),
                'total' => $rows->count(),
                'sort' => $period,
            ])
            ->sortBy('sort')
            ->values()
            ->take(-12)
            ->values();
    }
}
