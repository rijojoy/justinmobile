<?php

class UserTableSeeder extends Seeder {

    public function run() {
        $user = Sentry::createUser(array(
            'email'         => 'admin@example.org',
            'password'      => 'admin',
            'first_name'    => 'Aaron',
            'last_name'     => 'Dministrator',
            'activated'     => 1
        ));
        
        $group = Sentry::findGroupById(1);
        $user->addGroup($group);
    }
}