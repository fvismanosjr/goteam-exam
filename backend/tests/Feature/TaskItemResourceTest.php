<?php

use App\Models\User;
use App\Models\Task;
use App\Models\TaskItem;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->task = Task::factory()->create(['user_id' => $this->user->id]);
});

it('denies unauthenticated access', function () {
    $this->getJson("/api/tasks/{$this->task->id}/items")->assertUnauthorized();
});

it('lists task items', function () {
    Sanctum::actingAs($this->user);

    TaskItem::factory()->count(2)->create(['task_id' => $this->task->id]);

    $this->getJson("/api/tasks/{$this->task->id}/items")
        ->assertOk()
        ->assertJsonCount(2, 'taskItems');
});

it('creates a task item', function () {
    Sanctum::actingAs($this->user);

    $payload = ['task_id' => $this->task->id, 'description' => 'Simple task item'];

    $this->postJson("/api/tasks/{$this->task->id}/items", $payload)
        ->assertCreated()
        ->assertJsonFragment(['description' => 'Simple task item']);

    $this->assertDatabaseHas('task_items', [
        'task_id' => $this->task->id,
        'deleted_at' => null
    ]);
});

it('updates a task item', function () {
    Sanctum::actingAs($this->user);

    $item = TaskItem::factory()->create(['task_id' => $this->task->id]);

    $this->putJson("/api/tasks/{$this->task->id}/items/{$item->id}", [
        'task_id' => $this->task->id,
        'description' => 'Updated',
        'is_done' => true
    ])->assertOk();

    $this->assertDatabaseHas('task_items', [
        'id' => $item->id,
        'is_done' => true
    ]);
});

it('soft deletes a task item', function () {
    Sanctum::actingAs($this->user);

    $item = TaskItem::factory()->create(['task_id' => $this->task->id]);

    $this->deleteJson("/api/tasks/{$this->task->id}/items/{$item->id}")
        ->assertNoContent();

    $this->assertSoftDeleted('task_items', ['id' => $item->id]);
});
