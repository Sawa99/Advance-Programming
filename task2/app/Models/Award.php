<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;
use App\Models\Module;

class Award extends Model
{
    public function user(): hasMany {
        return $this->hasMany(User::class);
    }

    public function modules(): BelongsToMany {
        return $this->belongsToMany(Module::class, 'award_module');
    }
}
