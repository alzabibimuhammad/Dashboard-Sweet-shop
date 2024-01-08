<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\People;

class Payment extends Model
{
    use HasFactory;
    protected $request;

    protected $searchable = [
        'team_id',
        'created_at',
    ];

    public function scopeSearch(Builder $builder, string $term = '')
    {
        foreach ($this->searchable as $searchable) {
            if (str_contains($searchable, 'team_id')) {
                $team_id = People::orWhere('name', 'LIKE', "%$term%")->withTrashed()->get('id');
                foreach ($team_id as $team) {
                    $builder->where($searchable, $team->id);
                }
                continue;
            } elseif ($searchable === 'created_at') {
                if (preg_match('/^\d{4}$/', $term)) {
                    $termYear = substr($term, 0, 4);
                    $builder->whereYear('created_at', $termYear);
                }
                // Check if the search term matches year-month (YYYY-MM) or year-month-day (YYYY-MM-DD)
                if (preg_match('/^\d{4}-\d{2}$/', $term)) {
                    // Search for year and month (YYYY-MM)
                    $termYear = substr($term, 0, 4);
                    $termMonth = substr($term, 5, 2);
                    $builder->whereYear('created_at', $termYear)->whereMonth('created_at', $termMonth);

                } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $term)) {
                    // Search for year, month, and day (YYYY-MM-DD)
                    $termYear = substr($term, 0, 4);
                    $termMonth = substr($term, 5, 2);
                    $termDay = substr($term, 8, 2);
                    $builder->whereYear('created_at', $termYear)
                        ->whereMonth('created_at', $termMonth)
                        ->whereDay('created_at', $termDay);
                }
            } else {
                $builder->orWhere($searchable, 'like', "%$term%");
            }
        }
    return $builder->orderBy('created_at', 'desc');
    }
}
