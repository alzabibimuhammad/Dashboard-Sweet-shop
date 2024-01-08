<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;
    protected $request;
    protected $searchable = [
        'type_id',
        'created_at',
        'name',
    ];

    public function scopeSearch(Builder $builder, string $term = '')
    {
        foreach ($this->searchable as $searchable) {
            if (str_contains($searchable, 'type_id')) {
                $type_id = DB::select("select id from types where name = '$term'");
                foreach ($type_id as $type) {
                    $builder->where($searchable, $type->id);
                }
                continue;
            } elseif ($searchable === 'created_at') {
                if (preg_match('/^\d{4}$/', $term)) {
                    $termYear = substr($term, 0, 4);
                    $builder->whereYear('created_at', $termYear);

                }
                if (preg_match('/^\d{4}-\d{2}$/', $term)) {
                    // Search for year and month (YYYY-MM)
                    $termYear = substr($term, 0, 4);
                    $termMonth = substr($term, 5, 2);

                    $builder->whereYear('created_at', $termYear)->whereMonth('created_at', $termMonth);
                } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $term)) {
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
