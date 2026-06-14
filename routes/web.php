<?php

use App\Http\Controllers\{ProfileController, PlayerController, ResultController};
use Illuminate\Support\Facades\Route;

/**
 * ゲスト用ルーティング
 */
Route::get('/', fn() => view('welcome'));

/**
 * 認証済みユーザー用ルーティング
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ダッシュボード
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // プロフィール管理（Breeze標準仕様に準拠するため個別定義）
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
    
    // 対局者管理 CRUD
    Route::resource('players', PlayerController::class);
    
    // 対局結果管理 CRUD
    Route::resource('results', ResultController::class);
});

// 認証関連（ログイン、登録等）
require __DIR__.'/auth.php';