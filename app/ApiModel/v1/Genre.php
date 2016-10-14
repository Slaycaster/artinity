<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $primaryKey 		=	'int_genre_id';
    public $fillable 		=	[
    	'str_genre_name'
    ];
}
