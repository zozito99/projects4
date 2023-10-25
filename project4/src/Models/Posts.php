<?php

namespace BlogApiSlim\Models;

use BlogApiSlim\App\DB;
use BlogApiSlim\Models\A_Model;


use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Faker\Factory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Posts extends A_Model
{
    public int $id;
    public string $title;
    public int $year;
    public string $relased;

    public string $runtime;
    public string $genre;
    public string $director;
    public string $country;
    public string $poster;
    public int $imdp;
    public string $type;
    public string $actors;


    function findall(): array
    {
        $sql = "SELECT * FROM posts";
        $stm= $this->getPdo()->prepare($sql);
        $stm->execute();
        return $stm->fetchAll();
    }

    function findId(): array
    {
        return [];
    }

    function update(array $data): void
    {
        $sql = "UPDATE posts SET title=?, year=?, relased=?, runtime=?, genre=?, director=?, country=?, poster=?, imdp=?, type=?, actors=? WHERE id=?";

//        $title = filter_var($data['title'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
//        $year = filter_var($data['year'], FILTER_SANITIZE_NUMBER_INT);
//        $relased = filter_var($data['relased'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
//        $runtime = filter_var($data['runtime'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING );
//        $genre = filter_var($data['genre'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
//        $director = filter_var($data['director'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
//        $country = filter_var($data['country'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
//        $poster = filter_var($data['poster'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
//        $imdp = filter_var($data['imdp'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_NUMBER_INT);
//        $type = filter_var($data['type'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);
//        $actors = filter_var($data['actors'], FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_STRING);


            $stm = $this->getPdo()->prepare($sql);
            $stm->execute([$data[0], $data[1], $data[2], $data[3],$data[4], $data[5], $data[6], $data[7],$data[8], $data[9], $data[10], $data[11]]);

    }

    function insert(array $data): int
    {
        $sql = "INSERT INTO posts (title, year, relased, runtime,genre, director, country, poster, imdp, type, actors) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stm = $this->getPdo()->prepare($sql);
        $stm->execute([$data[0], $data[1], $data[2], $data[3],$data[4], $data[5], $data[6], $data[7],$data[8], $data[9], $data[10]]);
        return $this->getPdo()->lastInsertId();
    }
    function insertwithdata(array $data):void
    {

        $stm = $this->getPdo()->prepare("INSERT INTO posts (title, year, relased, runtime,genre, director, country, poster, imdp, type, actors) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stm->execute([$data[0], $data[1], $data[2], $data[3],$data[4], $data[5], $data[6], $data[7],$data[8], $data[9], $data[10]]);
    }


    function delete(int $id): bool
    {
        $sql = "DELETE FROM posts WHERE id=?";
        try {
            $stm = $this->getPdo()->prepare($sql);
            $stm->execute([$id]);
        } catch (\PDOException $exception){
            return false;
        }

        return true;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    function fakeData(Container $container): bool
    {
        $faker = Factory::create('en_US');
        $posts=new Posts($container);

       try {
            for ($i = 1; $i < 50; $i++) {
                $id = $faker->numberBetween(1 ,100);

                $posts->insertWithData([
                    $id,
                    $faker->title,
                    $faker->numberBetween(1900, 2023),
                    $faker->date(),
                    $faker->numberBetween(60, 180),
                    $faker->word,
                    $faker->name,
                    $faker->country,
                    $faker->imageUrl(200, 150, 'cats'),
                    $faker->numberBetween(1 ,100),
                    $faker->mimeType,
                    $faker->name,
                ]);
            }
       } catch (Exception $e){
           echo 'Error: ' . $e->getMessage();
          return false;
        }

        return true;
    }


    function findById(): array
    {
        return [];
    }
}

    function findById(): array
    {
        return [];
    }











