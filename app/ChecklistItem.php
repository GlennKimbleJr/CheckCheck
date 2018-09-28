<?php

namespace App;

use App\Checklist;
use Illuminate\Database\Eloquent\Model;
use App\Collections\ChecklistItemsCollection;

class ChecklistItem extends Model
{
    protected $fillable = ['name'];

    public function newCollection(array $models = [])
    {
        return new ChecklistItemsCollection($models);
    }

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
