<?php

class ProductModelProperty extends Eloquent {
    
    protected $table = 'products_models_properties';
    
    public function options() {
        return $this->hasMany('ProductModelPropertyOption', 'property_id')->orderBy('order_pos', 'asc');
    }
    
}