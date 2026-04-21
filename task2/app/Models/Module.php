<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Award;
use App\Models\Assignment;

class Module extends Model
{
    public function award(): BelongsToMany
    {
        return $this->belongsToMany(Award::class, 'award_modules');
    }

    public function assignments(): hasMany
    {
        return $this->hasMany(Assignment::class);
    }
}
