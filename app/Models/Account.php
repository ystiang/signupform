<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    /**
     * The table and primary key associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    protected $guarded = [];

}
