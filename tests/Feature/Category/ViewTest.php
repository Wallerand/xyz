<?php

namespace Tests\Feature\Category;

// 9

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewTest extends TestCase
{
    use RefreshDatabase;

    public function testRequirements()
    {
        // CSS
        $this->assertStringContainsString('select', file_get_contents(public_path('css/app.css')));
        $this->assertStringContainsString('.pagination', file_get_contents(public_path('css/app.css')));

        // Components
        $this->assertTrue(file_exists(resource_path('views/components/pagination.blade.php')));
        $this->assertStringContainsString('<a href="{{ route(\'app.categories.index\') }}">Catégories</a>', file_get_contents(resource_path('views/components/navigation.blade.php')));   
    }

    public function testCategoryViews()
    {
        // Views
        $this->assertTrue(file_exists(resource_path('views/app/categories/index.blade.php')));
        $this->assertTrue(file_exists(resource_path('views/app/categories/show.blade.php')));
    }

    public function testTrackViews()
    {
        $this->assertStringContainsString('<a href="{{ route(\'app.categories.show\', [\'category\' => $track->category->id]) }}" class="link">{{ $track->category->name }}</a>', file_get_contents(resource_path('views/app/tracks/show.blade.php')));
        $this->assertStringContainsString('<select name="category_id" id="category_id">', file_get_contents(resource_path('views/app/tracks/create.blade.php')));
    }

    public function testWeekViews()
    {
        $this->assertStringContainsString('<span>{{ $track->category->name }}</span>', file_get_contents(resource_path('views/app/weeks/show.blade.php')));
    }
}