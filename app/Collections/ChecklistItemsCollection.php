<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class ChecklistItemsCollection extends Collection
{
    public function completed()
    {
        return $this->filter(function ($item) {
            return $item->isCompleted();
        });
    }
}
