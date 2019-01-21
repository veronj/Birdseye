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
        $this->actingAs(factory('App\User')->create());
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
        $this->actingAs(factory('App\User')->create());
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
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        
        $project = $this->post('/projects', $attributes);
//dd($project);
        //'/project/' . $project->id, $project->path()
        $this->assertDatabaseHas('projects', $attributes);
        /* $this->get('/project/' . $project->id)
            ->assertSee($project->title)
            ->assertSee($project->description); */
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
    public function a_project_requires_an_owner()
    {
        $this->actingAs(factory('App\User')->create()); 
        $attributes = factory('App\Project')->raw(['owner_id' => null]);

        $this->post('/projects', $attributes)->assertSessionHasErrors('owner_id');
    }

    
    
}
