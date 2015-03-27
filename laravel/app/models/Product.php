<?php

class Product extends Eloquent {
    
    protected $table = 'products';
    
    public function models() {
        return $this->hasMany('ProductModel', 'product_id');
    }
    
}