<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    protected $fillable = ['name'];

    public function isCompleted()
    {
        return (bool) $this->completed_at;
    }

    public function complete()
    {
        $this->completed_at = now();
        $this->save();

        return $this;
    }
}
