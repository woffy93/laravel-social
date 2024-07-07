<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::fake(); //disable events
        Notification::fake(); //disable notifications

        $users = User::factory()->count(50)->create([
            'password' => Hash::make('TestPassword'), //same password for everyone to facilitate testing
        ]);
        $tags = Tag::factory(50)->create();

        $links = new Collection();
        foreach ($users as $user) {
            $numLinks = rand(10, 15);
            $links = $links->merge(
                Link::factory()->count($numLinks)->create([
                    'user_id' => $user->id,
                ])
            );

            $numFollowers = rand(0, count($users) - 1);
            $followers = $users->except([$user->id])->random($numFollowers); //except could be avoided
            $user->followMany($followers);
        }
        $links->each(function ($link) use ($users, $tags) {
            $link->tags()->attach($tags->random(rand(0, 5))->pluck('id')->toArray());
            $numLikes = rand(0, count($users)); // Random number of likes, up to the number of users
            $likers = $users->random($numLikes); // Get random likers
            foreach ($likers as $liker) {
                $liker->like($link);
            }
        });
    }
}
