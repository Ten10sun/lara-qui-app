<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class PlayController extends Controller
{
    /**
     * プレイヤー画面のトップページを表示する
     */
    public function top(Request $request)
    {
        // カテゴリー一覧を取得
        $categories = Category::all();
        // ビューにカテゴリー一覧を渡す
        return view('play.top', [
            'categories' => $categories,
        ]);
    }

    // クイズスタート画面
    public function categories(Request $request, int $categoryId)
    {

        // 指定されたカテゴリーIDのカテゴリーを取得
        $category = Category::withCount('quizzes')->findOrFail($categoryId);
        // dd($category->quizzes_count);
        // ビューにカテゴリー情報を渡す
        return view('play.start', [
            'category' => $category,
            'quizzesCount' => $category->quizzes_count,
        ]);
    }

    // クイズ出題画面
    public function quizzes(Request $request, int $categoryId)
    {
      // カテゴリーに紐づくクイズと選択肢を全て取得
      $category = Category::with('quizzes.options')->findOrFail($categoryId);
      // クイズをランダムに取得
      $quizzes = $category->quizzes->toArray();
      shuffle($quizzes); // 配列をシャッフル
      $quiz = $quizzes[0];
        // ビューにカテゴリー情報を渡す
        // クイズ一覧を取得
        // $quizzes = $category->quizzes()->inRandomOrder()->get();
        // return view('play.quizzes', [
        //     'category' => $category,
        //     'quizzes' => $quizzes,
        // ]);
      return view('play.quizzes', [
          'category' => $category,
          'quiz' => $quiz,
      ]);
    }
}
