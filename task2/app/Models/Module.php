<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Award;
use App\Models\Assignment;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'credits', 'level', 'is_completed'];

    public function awards(): BelongsToMany
    {
        return $this->belongsToMany(Award::class, 'award_module');
    }

    public function assignments(): hasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function isCompleted(): bool
    {
        // Must have at least one assignment, and every assignment must have a mark
        return $this->assignments()->exists() &&
            $this->assignments()->whereDoesntHave('marks')->doesntExist();
    }

    public function updateStatus(): void
    {
        $this->is_completed = $this->isCompleted();
        $this->save();
    }
}
