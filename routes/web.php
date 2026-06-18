<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Content;

Route::get('/', function () {

   
    return view('welcome');
    
});

Route::get('/dashboard', function () {
     $nullStatusCount = Content::whereNull('Status')->count();
    $contents = Content::all();
    return view('dashboard', compact('contents','nullStatusCount'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/post', function () {
    return view('Form-Post');
})->name('post');

Route::get('/Recycle', function () {
    $contents = Content::all();
    return view('Recycle', compact('contents'));
})->name('Recycle');



Route::get('/FWall', [App\Http\Controllers\ContentController::class, 'display'])->name('wall');

Route::post('/content', [App\Http\Controllers\ContentController::class, 'store'])->name('content.store');


Route::post('/content/accept/{id}', [ContentController::class, 'accept'])->name('accept');
Route::post('/content/reject/{id}', [ContentController::class, 'reject'])->name('reject');
Route::post('/content/recover/{id}', [ContentController::class, 'recover'])->name('recover');

Route::delete('/content/delete/{id}', [ContentController::class, 'destroy'])->name('delete');

require __DIR__.'/auth.php';
