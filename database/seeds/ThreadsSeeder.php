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
        factory('App\Channel', 2)->create()->each(function ($channel) {
            factory('App\Thread', 5)->create(['channel_id' => $channel->id])->each(function ($thread) {
                factory('App\Reply', rand(3, 10))->create(['thread_id' => $thread->id]);
            });
        });
    }
}
