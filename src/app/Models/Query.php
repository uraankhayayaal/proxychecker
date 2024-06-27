<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Query extends Model
{
    use HasFactory;

    protected $table = '_queries';

    protected $fillable = ['addresses'];
    
    public function proxies(): HasMany
    {
        return $this->hasMany(Proxy::class, 'queryId');
    }
}
