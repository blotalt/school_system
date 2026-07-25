<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    public function displayName(): string
    {
        if (app()->getLocale() === 'km') {
            return __('common.subject_names.' . $this->name, [], null) ?: $this->name;
        }
        return $this->name;
    }
}