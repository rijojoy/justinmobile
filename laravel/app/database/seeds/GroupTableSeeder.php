<?php

class GroupTableSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();
        
        Group::create(array(
            'name'          => 'admin',
            'permissions'   => json_encode(array(
                'admin'     => 1,
            ))
        ));
    }

}