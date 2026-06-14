<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // DBファサードをインポート
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(): View
    {
        // 既存のテーブルから全データを取得
        $players = DB::table('players')->get();

        return view('players', compact('players'));
    }
}