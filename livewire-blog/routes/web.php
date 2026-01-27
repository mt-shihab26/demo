<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::welcome');
Route::livewire('/counter', 'pages::counter');
Route::livewire('/todos', 'pages::todos');
