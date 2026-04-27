<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Award;
use App\Models\Assignment;

class Module extends Model
{
    protected $fillable = ['name', 'credits', 'level', 'is_completed'];

    public function awards(): BelongsToMany
    {
        return $this->belongsToMany(Award::class, 'award_module');
    }

    public function assignments(): hasMany
    {
        return $this->hasMany(Assignment::class);
    }
}
