<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $authors = factory(\App\Author::class, 10)->create();
        $contenTypes = factory(\App\ContentType::class, 3)->create();
        $organisations = factory(\App\Organisation::class, 10)->create();
        $regions = factory(\App\Region::class,10)->create();
        $sources =  factory(\App\Source::class,10)->create();

        $topicsFirstLevel = factory(\App\Topic::class, 2)->create();
        $topicsSecondLevel = new Collection();

        foreach ($topicsFirstLevel as $parent){
           $topics = factory(\App\Topic::class, 10)
                ->create([
                    'parent_topic_id' => $parent->id
                ]);
            $topicsSecondLevel->merge($topics);
        }
        $articleCount = 100;
//       dd([
//           'organisation_id' => $organisations[rand(0,count($organisations)-1)]->id,
//           'source_id' => $sources[rand(0,count($sources)-1)]->id,
//           'content_type_id' => $contenTypes[rand(0,count($contenTypes)-1)]->id,
//           'author_id' => $authors[rand(0,count($authors)-1)]->id,
//           'region_id' => $regions[rand(0,count($regions)-1)]->id,
//           'topic_id' => $topics[rand(0,count($topics)-1)]->id,
//
//       ]);
        for($i = 0 ; $i < $articleCount; $i++){
            factory(\App\Article::class)->create(
                [
                    'organisation_id' => 1,
                    'source_id' => $sources[rand(0,count($sources)-1)]->id,
                    'content_type_id' => $contenTypes[rand(0,count($contenTypes)-1)]->id,
                    'author_id' => $authors[rand(0,count($authors)-1)]->id,
                    'region_id' => $regions[rand(0,count($regions)-1)]->id,
                    'topic_id' => $topics[rand(0,count($topics)-1)]->id,

                ]
            );
        }
    }
}
