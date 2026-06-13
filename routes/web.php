<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- トップページ ---
Route::get('/', function () {
    return view('welcome');
});

// --- 認証済みユーザーのみアクセス可能なグループ ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ダッシュボード
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 団体管理 (owner用)
    Route::get('/user', function () {
        return view('user.index'); // 後でファイルを作ります
    })->name('user.index');

    // 対局者管理
    Route::get('/players', function () {
        return view('players.index'); // 後でファイルを作ります
    })->name('players.index');

    // 対局結果管理
    Route::get('/results', function () {
        return view('results.index'); // 後でファイルを作ります
    })->name('results.index');

    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';