<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Status 微博模型
 * @package App\Models
 */
class Status extends Model
{
    protected $fillable = ['info'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
