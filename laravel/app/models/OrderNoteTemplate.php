<?php

class OrderNoteTemplate extends Eloquent {
    
    protected $table = 'orders_notes_templates';
    
    public $timestamps = false;
    
    public function status() {
        return $this->belongsTo('OrderStatus');
    }
    
}