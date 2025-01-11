<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class status extends Model
{
    protected $table = 'statuses';
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
