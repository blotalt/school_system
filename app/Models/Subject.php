<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    public function displayName(): string
    {
        if (app()->getLocale() === 'km') {
            return __('common.subjects.' . $this->name);
        }
        return $this->name;
    }
}