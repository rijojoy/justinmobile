<?php

class OrderNote extends Eloquent {
    
    protected $table = 'orders_notes';
    
    public function user() {
        return $this->belongsTo('User', 'user_id');
    }
    
    public function status() {
        return $this->belongsTo('OrderStatus');
    }
    
}