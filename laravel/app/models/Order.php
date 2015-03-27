<?php

class Order extends Eloquent {
    
    public function status() {
        return $this->belongsTo('OrderStatus', 'status_id');
    }
    
    public function product() {
        return $this->belongsTo('Product', 'product_id');
    }
    
    public function model() {
        return $this->belongsTo('ProductModel', 'model_id');
    }
    
    public function notes() {
        return $this->hasMany('OrderNote');
    }
    
}