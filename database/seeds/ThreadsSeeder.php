<?php

use Illuminate\Database\Seeder;

class ThreadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Thread', 50)->create()->each(function ($thread) {
            factory('App\Reply', 10)->create(['thread_id' => $thread->id]);
        });
    }
}
