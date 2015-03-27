<?php

class ProductModel extends Eloquent {
    
    protected $table = 'products_models';
    
    public function propertyies() {
        return $this->hasMany('ProductModelProperty', 'model_id')->orderBy('order', 'asc');
    }
    
}