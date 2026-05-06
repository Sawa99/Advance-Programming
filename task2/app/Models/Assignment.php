<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Module;
use App\Models\Mark;

class Assignment extends Model
{
    protected $fillable = ['name', 'module_id', 'weight', 'total_marks'];
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function marks(): hasMany
    {
        return $this->hasMany(Mark::class);
    }
}
