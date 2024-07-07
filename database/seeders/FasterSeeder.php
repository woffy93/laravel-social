<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class FasterSeeder extends Seeder
{
    const USER_NUM = 1000;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::fake();
        Notification::fake();
        DB::disableQueryLog();

        $password = Hash::make('TestPassword'); //same password for everyone to facilitate testing
        $users = User::factory()->count(self::USER_NUM)->create([
            'password' => $password
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

            $numFollowers = rand(0, self::USER_NUM - 1);
            $followers = $users->except([$user->id])->random($numFollowers); //except could be avoided
            $user->followMany($followers);
        }
        $linkTagData = [];
        $likeData = [];
        $links->each(function ($link) use ($users, $tags, &$linkTagData, &$likeData) {
            $linkTags = $tags->random(rand(0, 5))->pluck('id')->toArray();
            foreach ($linkTags as $tagId) {
                $linkTagData[] = ['link_id' => $link->id, 'tag_id' => $tagId];
            }

            $numLikes = rand(0, self::USER_NUM); // Random number of likes, up to the number of users
            $likers = $users->random($numLikes); // Get random likers
            foreach ($likers as $liker) {
                $likeData[] = [
                    'user_id' => $liker->id,
                    'likable_id' => $link->id,
                    'likable_type' => Link::class,
                ];
            }
        });
        if (!empty($linkTagData)) {
            DB::table('link_tag')->insert($linkTagData); // Batch insert link_tag pivot table data
        }
        if (!empty($likeData)) {
            DB::table('likes')->insert($likeData); // Batch insert likes
        }
    }
}
