<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proxy extends Model
{
    use HasFactory;

    protected $table = '_proxies';

    protected $fillable = [
        'ip',
        'port',
        'type',
        'country',
        'city',
        'status',
        'speed',
        'timeout',
        'externalIp',
        'checkedAt',
        'queryId',
    ];
    
    public function userQuery(): BelongsTo
    {
        return $this->belongsTo(Query::class, 'queryId');
    }
}
