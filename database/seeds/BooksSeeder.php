<?php

use App\Article;
use App\ContentType;
use App\Organisation;
use App\Region;
use App\Source;
use App\Topic;
use App\Author;
use Faker\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    public static $faker;
    /**
     * Seed the application's database.
     * art db:seed --class=BooksSeeder
     * @return void
     */
    public function run()
    {
        $topics = Topic::innerPolitics()->get();
        self::$faker = Factory::create();
        foreach ($topics as $topic){
            $this->seedTopic($topic);
            $this->command->info('go-go' .$topic->title);
        }
    }

    protected function seedTopic(Topic $topic){
        $subTopics = $topic->children();
        foreach ($subTopics as $st){
            $this->createBook($st,3);
        }
    }

    protected function createBook(Topic $topic, $count){
        for($i = 0; $i < $count; $i++){
            $author = Author::inRandomOrder()->first();
            $region = Region::inRandomOrder()->first();
            $org = Organisation::inRandomOrder()->first();
            $source = Source::inRandomOrder()->first();
            $data = [
                'topic_id' => $topic->id,
                'format' => Article::TEXT_TYPE,
                'img' => $this->getRandomImg(),
                'source_id' => $source->id,
                'year' => rand(1999,2019),
                'html' => '<p>'.self::$faker->text().'</p>',
                'content_type_id' => ContentType::bookTypeID()
            ];
            $art = factory(Article::class)->create($data);
            $art->authors()->attach($author);
            $art->regions()->attach($region);
            $art->organisations()->attach($org);
            $art->authors_string = $author->fio;
            $art->save();
        }
    }

    protected function getRandomImg(){
        $imgs = ['077','079','081','083','084','088','097','104','105','107','127','128','129','141','146','151','154'];
        return 'image'.$imgs[rand(0,sizeof($imgs)-1)].'.png';
    }
}
