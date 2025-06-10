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
    // セッションの削除
    $request->session()->forget('resultArray');

    // 指定されたカテゴリーIDのカテゴリーを取得
    $category = Category::withCount('quizzes')->findOrFail($categoryId);
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



    // セッションに保存されているクイズIDの配列を取得
    $resultArray = session('resultArray');
    // セッションに保存されていない場合は新規作成
    if (!$resultArray) {
      $resultArray = $this->setResultArrayForSession($category);

      // セッションに保存
      session(['resultArray' => $resultArray]);
    }

    $noAnswerResult = collect($resultArray)->filter(function ($item) {
      return $item['result'] === null;
    })->first();

    // resultがnullの要素が存在しない場合は、全てのクイズに回答済みとみなす
    if (!$noAnswerResult) {

      // 全てのクイズに回答済みの場合、結果画面にリダイレクト
      return redirect()->route('categories.quizzes.result', ['categoryId' => $categoryId]);
    }
    // クイズIDに紐づくクイズを取得
    $quiz = $category->quizzes->firstWhere('id', $noAnswerResult['quizId'])->toArray();

    return view('play.quizzes', [
      'categoryId' => $categoryId,
      'quiz' => $quiz,
    ]);
  }

  // クイズ解答画面
  public function answer(Request $request, int $categoryId)
  {
    $quizId = $request->quizId;
    $selectedOptions = $request->optionId === null ? [] : (array)$request->optionId;

    // カテゴリーに紐づくクイズと選択肢を全て取得
    $category = Category::with('quizzes.options')->findOrFail($categoryId);
    $quiz = $category->quizzes->firstWhere('id', $quizId);
    $quizOptions = $quiz->options->toArray();
    $isCorrectAnswer = $this->isCorrectAnswer($selectedOptions, $quizOptions);

    // セッションからクイズIDと解答結果の配列を取得
    $resultArray = session('resultArray');

    // 解答結果をセッションに保存
    foreach ($resultArray as $index => $result) {
      if ($result['quizId'] === (int)$quizId) {
        // $result['result'] = $isCorrectAnswer ? 'correct' : 'incorrect';
        $resultArray[$index]['result'] = $isCorrectAnswer;
        break;
      }
    }
    // セッションに更新された結果を保存
    session(['resultArray' => $resultArray]);

    return view('play.answer', [
      'categoryId' => $categoryId,
      'quiz' => $quiz, // ←ここを配列ではなくオブジェクトのまま渡す
      'quizOptions' => $quizOptions,
      'selectedOptions' => $selectedOptions,
      'isCorrectAnswer' => $isCorrectAnswer,
    ]);
  }


  // クイズ結果画面
  public function result(Request $request, int $categoryId)
  {
    // セッションからクイズIDと解答結果の配列を取得
    $resultArray = session('resultArray');
    $questionCount = count($resultArray);
    $correctCount = collect($resultArray)->filter(function ($item) {
      return $item['result'] === true;
    })->count();

    return view('play.result', [
      'categoryId' => $categoryId,
      'correctCount' => $correctCount,
      'questionCount' => $questionCount,]);
  }
  

  // 初回の時にセッションにクイズIDと解答状況を保存する
  private function setResultArrayForSession(Category $category){
          // クイズIDを全て抽出する
      $quizIds = $category->quizzes->pluck('id')->toArray();
      shuffle($quizIds); // クイズIDをシャッフル 
      $resultArray = [];
      foreach ($quizIds as $quizId) {
        // クイズIDに紐づくクイズを取得
        $resultArray[] = [
          'quizId' => $quizId,
          'result' => null,
        ];
      }
      return $resultArray;
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
