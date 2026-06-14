<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ResultController extends Controller
{
    /**
     * 対局結果一覧を表示
     */
    public function index(): View
    {
        // 1. カラム名が 'match_date' であることを確認し、latest() を修正
        $results = DB::table('results')
            ->join('players as winners', 'results.winner_id', '=', 'winners.id')
            ->join('players as losers', 'results.loser_id', '=', 'losers.id')
            ->select('results.*', 'winners.name as winner_name', 'losers.name as loser_name')
            ->latest('match_date') // ここを match_date に修正
            ->get();

        return view('results', compact('results'));
    }

    /**
     * 新規登録フォーム表示
     */
    public function create(): View
    {
        $players = DB::table('players')->get();
        return view('results_create', compact('players'));
    }

    /**
     * 新規登録処理
     */
    public function store(Request $request): RedirectResponse
    {
        // 2. バリデーションも match_date に合わせる
        $validated = $request->validate([
            'winner_id'  => 'required|exists:players,id',
            'loser_id'   => 'required|exists:players,id|different:winner_id',
            'match_date' => 'required|date', // ここを match_date に修正
        ]);

        DB::table('results')->insert($validated);

        return redirect()->route('results.index')->with('success', '対局結果を登録しました。');
    }
}