<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Award;
use App\Models\Module;

class award_module extends Model{
    public function award(): BelongsTo
    {
        return $this->belongsTo(Award::class);
    }
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
