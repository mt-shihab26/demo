<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

it('renders successfully', function () {
    Livewire::test('screens.posts.create')
        ->assertStatus(200);
});

it('can create new post', function () {
    User::factory()->create();

    $post = Post::whereTitle('Some title')->first();
    assertNull($post);

    Livewire::test('screens.posts.create')
        ->set('title', 'Some title')
        ->set('content', 'Some content')
        ->call('save');

    $post = Post::whereTitle('Some title')->first();

    assertNotNull($post);

    assertEquals('Some title', $post->title);
    assertEquals('Some content', $post->content);
});

it('title is required', function () {
    User::factory()->create();

    Livewire::test('screens.posts.create')
        ->set('title', '')
        ->set('content', 'Some content')
        ->call('save')
        ->assertHasErrors(['title' => 'required']);
});
