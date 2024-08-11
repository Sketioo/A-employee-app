<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name', 'phone', 'image', 'position', 'division_id',
    ];

    public function division() {
        return $this->belongsTo(Division::class);
    }


    //* Penggunaan scope query
    public function scopeFilter($query, $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['division_id'])) {
            $query->where('division_id', $filters['division_id']);
        }
    }
}
