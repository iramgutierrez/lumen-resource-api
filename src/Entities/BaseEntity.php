<?php

namespace IramGutierrez\API\Entities;

use Illuminate\Database\Eloquent\Model;

abstract class BaseEntity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id' , 'name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $hidden = [];

    /**
     *
     * @var array
     */

    protected $appends = [];

}