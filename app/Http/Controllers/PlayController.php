<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Arr;

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
      'categoryId' => $categoryId,
      'quiz' => $quiz,
    ]);
  }

  // kクイズ解答画面
  public function answer(Request $request, int $categoryId)
  {
    // dd($categoryId, $request);
    $quizId = $request->quizId;
    $selectedOptions = $request->optionId === null ? [] : (array)$request->optionId;

    // カテゴリーに紐づくクイズと選択肢を全て取得
    $category = Category::with('quizzes.options')->findOrFail($categoryId);
    $quiz = $category->quizzes->firstWhere('id', $quizId);    
    $quizOptions = $quiz->options->toArray();
    $isCorrectAnswer = $this->isCorrectAnswer($selectedOptions, $quizOptions);
    return view('play.answer'
    , [
      'categoryId' => $categoryId,
      'quiz' => $quiz,
      // 'quiz' => $quiz->toArray(),
      'quizOptions' => $quizOptions,
      'selectedOptions' => $selectedOptions,
      'isCorrectAnswer' => $isCorrectAnswer,
    ]
  );
  }

  // プレイヤーの解答が正解か不正解かを判定する

  private function isCorrectAnswer(array $selectedOptions, array $quizOptions)
  {
    // クイズの正解の選択肢を全て取得
    $correctOptions = array_filter($quizOptions, function ($option) {
      return $option['is_correct'] === 1;
    });

    // プレイヤーが選んだ正解の選択肢の個数と正解の選択肢の個数を比較
    if (count($selectedOptions) !== count($correctOptions)) {
      return false; // 不正解
    }
    // 正解の選択肢IDとプレイヤーの選択肢IDが全て一致するかを比較
    foreach ($correctOptions as $correctOption) {
      if (!in_array($correctOption['id'], $selectedOptions)) {
        return false; // 不正解
      }
    }
    return true; // 正解
  }
}
