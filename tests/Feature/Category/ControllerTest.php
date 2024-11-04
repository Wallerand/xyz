<?php

namespace Tests\Feature\Category;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

class ControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRouteIndexCategoriesExist()
    {
        $this->assertTrue(Route::has('app.categories.index'));
    }

    public function testRouteShowCategoryExist()
    {
        $this->assertTrue(Route::has('app.categories.show'));
    }

    public function testCategoryControllerClassExist()
    {
        $this->assertTrue(class_exists(\App\Http\Controllers\CategoryController::class));
    }

    public function testCategoryControllerMethodsExist()
    {
        $this->assertCount(5, get_class_methods(\App\Http\Controllers\CategoryController::class));
        $this->assertTrue(method_exists(\App\Http\Controllers\CategoryController::class, 'index'));
        $this->assertTrue(method_exists(\App\Http\Controllers\CategoryController::class, 'show'));
    }

    public function testCategoryControllerUsePaginationAndTracksCount()
    {
        $this->assertStringContainsString('paginate', file_get_contents(app_path('Http/Controllers/CategoryController.php')));
        $this->assertStringContainsString('withCount(\'tracks\')', file_get_contents(app_path('Http/Controllers/CategoryController.php')));
    }
}