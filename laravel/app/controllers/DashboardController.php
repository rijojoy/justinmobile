<?php

class DashboardController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('auth');
    }
    
    public function getIndex() {
        $monday = date("Y-m-d H:i:s", strtotime('last monday', strtotime('tomorrow')));
        $orders_week = \Order::where('created_at', '>', $monday)->get();
        $orders_new = \Order::where('status_id', \OrderStatus::first()->id)->take(10)->orderBy('created_at', 'desc')->get();
        $logs = \ActionLog::all()->take(10);
        return View::make('admin.dashboard.index', array(
            'orders_week' => $orders_week,
            'orders_new' => $orders_new,
            'logs' => $logs,
        ));
    }
    
}