<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::welcome')->name('home');
Route::livewire('/counter', 'pages::counter')->name('counter');
Route::livewire('/todos', 'pages::todos')->name('todos');
Route::livewire('/posts', 'pages::posts')->name('posts');
