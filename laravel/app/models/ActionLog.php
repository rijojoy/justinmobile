<?php

class ActionLog extends Eloquent {
    
    protected $table = 'logs';
    
    public function __construct() {
        Eloquent::unguard();
    }
    
}