<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_shows_a_task(): void
    {
        $task = Task::factory()->create();
        $response = $this->get(route('api.tasks.show', $task))
            ->assertSuccessful();

        $data = $response->json()['data'];

        $this->assertEquals($task->toArray(), $data);
    }

    public function test_it_shows_all_tasks(): void
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->get(route('api.tasks.index'))
            ->assertSuccessful();
        $data = $response->json()['data'];

        $this->assertEquals($tasks->count(), count($data));

        $tasks->each(function (Task $task) use($data) {
            $index = array_search($task->toArray(), $data);
            $this->assertNotNull($index);
        });
    }

    public function test_it_stores_a_task(): void
    {
        $task = [
            'description' => 'my new task',
        ];

        $this->post(route('api.tasks.store'), $task)
            ->assertSuccessful();

        $this->assertDatabaseHas('tasks', $task);
    }

    public function test_it_updates_a_task(): void
    {
        $task = Task::factory()->create();
        $newDescription = 'new description';
        
        $this->assertDatabaseHas('tasks', $task->toArray());

        $this->patch(route('api.tasks.update', $task->id), ['description' => $newDescription])
            ->assertSuccessful();

        $this->assertDatabaseHas('tasks', array_merge($task->toArray(), ['description' => $newDescription]));
    }

    public function test_it_destroys_a_task() : void
    {
        $task = Task::factory()->create();
        $this->assertDatabaseHas('tasks', $task->toArray());

        $this->delete(route('api.tasks.destroy', $task))->assertSuccessful();

        $this->assertDatabaseMissing('tasks', $task->toArray());
    }
}
