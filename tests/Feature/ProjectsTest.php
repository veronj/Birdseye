<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;


class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test  */
    public function only_auth_user_can_post_a_project()
    {
        //$this->withoutExceptionHandling();

        $attributes = factory('App\Project')->raw();
        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /** @test  */
    public function a_user_can_create_a_project()
    {
        //$this->withoutExceptionHandling();
        
        $this->signIn(); //See TestCase.php  $this->actingAs(factory('App\User')->create());
        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);
        
    }

    /** @test  */
    public function a_user_can_view_projects()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post('/projects', $attributes);
        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test  */
    public function a_user_can_view_a_project()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());
                        
        $project = factory('App\Project')->create(['owner_id' => auth()->user()->id, 'description' => "lorem ipsum", "title" => "This post"]);

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'description' => 'lorem ipsum']);
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description); 
    }

    /** @test  */
    public function a_project_requires_a_title()
    {
       $this->actingAs(factory('App\User')->create());
       $attributes = factory('App\Project')->raw(['title' => '']);
       $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test  */
    public function a_project_requires_a_description()
    {
       $this->actingAs(factory('App\User')->create()); 
       $attributes = factory('App\Project')->raw(['description' => '']);
       $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /** @test  */
    public function an_auth_user_cannot_see_projects_of_others()
    {
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }
   
    
}
