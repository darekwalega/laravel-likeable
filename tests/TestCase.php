<?php

use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp()
    {
        $this->setUpDatabase();
        $this->migrateTables();
    }

    protected function setUpDatabase()
    {
        $database = new DB;
        $database->addConnection(['driver' => 'sqlite', 'database' => ':memory:']);
        $database->bootEloquent();
        $database->setAsGlobal();
    }

    protected function migrateTables()
    {
        DB::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();  
        });

        DB::schema()->create('entities', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();  
        });

        DB::schema()->create('likes', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('likeable_id');
            $table->string('likeable_type');
            $table->unsignedInteger('owner_id');
            $table->string('owner_type');
            $table->enum('type', ['like', 'dislike'])->default('like');
            $table->timestamps();
            $table->unique(['likeable_id', 'likeable_type', 'owner_id', 'owner_type'], 'like_owner_unique');
        });
    }

    protected function makeUser()
    {
        $user = new User;
        
        $user->name = 'Some name';
        $user->save();
        
        return $user; 
    }

    protected function makeEntity()
    {
        $entity = new Entity;
        
        $entity->title = 'Some title';
        $entity->save();
        
        return $entity; 
    }
}

class Entity extends \Illuminate\Database\Eloquent\Model
{
    use Abix\Likeable\HasLikes;
}

class User extends \Illuminate\Database\Eloquent\Model
{
    // ...
}
