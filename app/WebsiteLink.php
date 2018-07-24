<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteLink extends Model
{
    protected $fillable = ['website_name', 'website_url', 'website_image', 'deleted'];
}
