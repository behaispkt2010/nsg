<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'title_seo','slug','description', 'template','content','author_id','status', 'deleted'];

}
