<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
    ];

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function scopeFilterByName($query, $name = null)
    {
        if ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        }

        return $query;
    }
}
