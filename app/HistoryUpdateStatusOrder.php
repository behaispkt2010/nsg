<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryUpdateStatusOrder extends Model
{
    protected $table = 'history_update_status_order';
    protected $fillable = ['order_id','status','author_id', 'deleted'];
}
