<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

// --- 公開エリア ---
Route::get('/', function () {
    return view('welcome');
});

// --- 認証済みエリア ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ダッシュボード
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // プロフィール管理
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    // 対局者管理 (リソースフルルーティング)
    // index, create, store, show, edit, update, destroy が自動生成されます
    Route::resource('players', PlayerController::class);
});

// 認証系ルートの読み込み
require __DIR__.'/auth.php';