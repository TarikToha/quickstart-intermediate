<?php

namespace App\Repositories;

use App\Paper;

class PaperRepository
{
    public function papers()
    {
        return Paper::orderBy('created_at', 'asc')
            ->get();
    }

    public function paperExists($name)
    {
        return Paper::where('name', $name)->exists();
    }
}
