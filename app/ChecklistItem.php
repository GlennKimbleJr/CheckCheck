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
        return $this->setCompletedAt(now());
    }

    public function makeIncomplete()
    {
        return $this->setCompletedAt(null);
    }

    private function setCompletedAt($time)
    {
        $this->completed_at = $time;
        $this->save();

        return $this;
    }
}
