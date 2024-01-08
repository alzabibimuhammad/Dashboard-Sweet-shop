<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Type extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $searchable = [
        'name',
        'price',
    ];

    public function scopeSearch(Builder $builder, string $term = '')
    {
        $builder->where(function($query) use ($term) {
            foreach ($this->searchable as $searchable) {
                $query->orWhere($searchable, 'like', "%$term%");
            }
        });

        return $builder->orderBy('created_at', 'desc');
    }



}


