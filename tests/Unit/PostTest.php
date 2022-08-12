<?php

namespace Tests\Unit;
use Faker\Faker;
use App\Models\Post;
use App\Models\Category;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use WithFaker;
    public function __construct()
    {
        $this->setUpFaker();
    }
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_success_create_post()
    {
        $this->setUpFaker();
        $data = [
            'title' => $this->faker->title(),
            'content' => $this->faker->text(),
            'image' => $this->faker->imageUrl(200,200),
            'user_id' => $this->faker->numberBetween(1,User::count()),
            'category_id' => $this->faker->numberBetween(1,Category::count())
        ];
        $this->post(route('post.store'),$data)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            'message' => 'Post save successfully',
            'data' => array([
                'id' => $data->id,
                'title' => $data->title,
                'content' => $data->content,
                'image' => $data->image,
                'user_id' => $data->user_id,
                'category_id' => $data->category_id,
            ])
            ]);
    }
}
