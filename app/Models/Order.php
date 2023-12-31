<?php

namespace App\Models;

use App\Models\Solditems;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    public function soldItems()
    {
        return $this->hasMany(Solditems::class);
    }
}
