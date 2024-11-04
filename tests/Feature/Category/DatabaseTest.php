<?php

namespace Tests\Feature\Category;

use App\Models\Track;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoriesMigration()
    {
        $this->assertTrue(Schema::hasTable('categories'));
        $this->assertTrue(Schema::hasColumn('categories', 'id'));
    }

    public function testTracksMigration()
    {
        $this->assertTrue(Schema::hasColumn('tracks', 'category_id'));
        $this->assertTrue(Schema::hasIndex('tracks', 'tracks_category_id_foreign'));
    }

    public function testCategoryModel()
    {
        $this->assertTrue(class_exists(\App\Models\Category::class));
        $this->assertTrue(method_exists(\App\Models\Category::class, 'tracks'));
    }

    public function testTrackModel()
    {
        $this->assertTrue(method_exists(\App\Models\Track::class, 'category'));

        $trackProperties = (array) new Track();
        $this->assertContains('category_id', $trackProperties["\0*\0fillable"]);
    }

    public function testCategoryFactory()
    {
        $this->assertTrue(class_exists(\Database\Factories\CategoryFactory::class));
    }
}