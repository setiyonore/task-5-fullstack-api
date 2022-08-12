<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;
class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        // set your headers here
        $this->withHeaders([
                    'Authorization' => 'Bearer ' . $this->authenticate(),
                    'Accept' => 'application/json'
        ]);

    }
    protected function authenticate()
    {
        $user = User::create([
            'name' => 'setiyono',
            'email' => 'setiyono.ressly@mail.com',
            'password' => 12345678
        ]);

        if(!auth()->attempt(['email'=>'setiyono.ressly@mail.com','password'=>12345678])) {
            return response(['message' => 'Login credentials are invaild']);
        }
        return $accessToken = auth()->user()->createToken('authToken')->accessToken;
    }

    public function test_success_create_post()
    {
        $data = [
            'title' => $this->faker->title(),
            'content' => $this->faker->text(),
            'image' => $this->faker->imageUrl(200,200),
            'user_id' => $this->faker->numberBetween(1,User::count()),
            'category_id' => $this->faker->numberBetween(1,Category::count())
        ];
        $this->post(route('post.store'),$data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'title',
                        'content',
                        'image',
                        'user_id',
                        'category_id'
                    ]
                ]
            );
    }
}
