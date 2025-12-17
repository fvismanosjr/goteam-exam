<?php

use App\Models\User;
use App\Models\Task;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/*
|--------------------------------------------------------------------------
| Task Resource Controller Tests
|--------------------------------------------------------------------------
*/

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('denies unauthenticated access', function () {
    $this->getJson('/api/tasks')
        ->assertUnauthorized();
});

it('lists only authenticated user tasks', function () {
    Sanctum::actingAs($this->user);

    Task::factory()->count(3)->create([
        'user_id' => $this->user->id,
    ]);

    Task::factory()->create(); // other user

    $this->getJson('/api/tasks')
        ->assertOk()
        ->assertJsonCount(3, 'tasks');
});

it('creates a task with task items', function () {
    Sanctum::actingAs($this->user);

    $payload = [
        'user_id' => $this->user->id,
        'description' => 'Build Nuxt frontend',
    ];

    $this->postJson('/api/tasks', $payload)
        ->assertCreated()
        ->assertJsonFragment([
            'user_id' => $this->user->id,
        ]);

    $this->assertDatabaseHas('task_items', [
        'description' => 'Build Nuxt frontend',
    ]);
});

it('shows a task', function () {
    Sanctum::actingAs($this->user);

    $task = Task::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $this->getJson("/api/tasks/{$task->id}")
        ->assertOk()
        ->assertJsonFragment([
            'id' => $task->id,
        ]);
});

it('updates a task', function () {
    Sanctum::actingAs($this->user);

    $task = Task::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $this->putJson("/api/tasks/{$task->id}", [
        'user_id' => $this->user->id,
    ])
        ->assertOk();

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'user_id' => $this->user->id,
    ]);
});

it('deletes a task', function () {
    Sanctum::actingAs($this->user);

    $task = Task::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $this->deleteJson("/api/tasks/{$task->id}")
        ->assertNoContent();

    $this->assertSoftDeleted('tasks', [
        'id' => $task->id,
    ]);
});
