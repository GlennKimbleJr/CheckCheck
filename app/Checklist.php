<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function isComplete()
    {
        return $this->items->count() == $this->items->completed()->count();
    }
}
