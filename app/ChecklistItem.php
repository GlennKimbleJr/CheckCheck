<?php

namespace App;

use App\Checklist;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    protected $fillable = ['name'];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function isCompleted()
    {
        return (bool) $this->completed_at;
    }

    public function makeComplete()
    {
        $this->completed_at = now();
        $this->save();

        return $this;
    }

    public function makeIncomplete()
    {
        $this->completed_at = null;
        $this->save();

        return $this;
    }
}
