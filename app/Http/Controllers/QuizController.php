<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Http\Request;


class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * クイズ新規登録画面を表示する
     */
    public function create(Request $request, int $categoryId)
    {
        return view('admin.quizzes.create', [
            'categoryId' => $categoryId,
        ]);
    }

    /**
     * クイズ新規登録処理
     */
    public function store(StoreQuizRequest $request, int $categoryId)
    {
        // 先にクイズの登録
        $quiz = new Quiz();
        $quiz->category_id = $categoryId;
        $quiz->question = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();
        // クイズIDを元に選択肢(option)を登録
        $options = [
            ['quiz_id' => $quiz->id, 'content' => $request->content1, 'is_correct' => $request->isCorrect1],
            ['quiz_id' => $quiz->id, 'content' => $request->content2, 'is_correct' => $request->isCorrect2],
            ['quiz_id' => $quiz->id, 'content' => $request->content3, 'is_correct' => $request->isCorrect3],
            ['quiz_id' => $quiz->id, 'content' => $request->content4, 'is_correct' => $request->isCorrect4],
        ];

        foreach ($options as $option) {
            $newOption = new Option();
            $newOption->quiz_id = $option['quiz_id'];
            $newOption->content = $option['content'];
            $newOption->is_correct = $option['is_correct'];
            $newOption->save();
        }
        // クイズ登録後、カテゴリー詳細画面へリダイレクト
        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * クイズ編集画面を表示する
     */
    public function edit(Request $request, int $categoryId, int $quizId)
    {
        $quiz = Quiz::with('category', 'options')->findOrFail($quizId);
        return view('admin.quizzes.edit', [
            'quiz' => $quiz,
            'category' => $quiz->category,
            'options' => $quiz->options,
        ]);
    }

    /**
     * クイズ更新処理
     */
    public function update(UpdateQuizRequest $request, int $categoryId, int $quizId)
    {
        // Quizの更新
        $quiz = Quiz::findOrFail($quizId);
        $quiz->question = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();
        // // Optionの更新
        // 受け取ったリクエストから選択肢(option)の情報を更新
        $options = [
            ['optionId' => (int)$request->optionId1, 'content' => $request->content1, 'is_correct' => $request->isCorrect1],
            ['optionId' => (int)$request->optionId2, 'content' => $request->content2, 'is_correct' => $request->isCorrect2],
            ['optionId' => (int)$request->optionId3, 'content' => $request->content3, 'is_correct' => $request->isCorrect3],
            ['optionId' => (int)$request->optionId4, 'content' => $request->content4, 'is_correct' => $request->isCorrect4],
        ];
        foreach ($options as $option) {
            $updateOption = Option::findOrFail($option['optionId']);
            $updateOption->content = $option['content'];
            $updateOption->is_correct = $option['is_correct'];
            $updateOption->save();
        }


        // 更新後、カテゴリー詳細画面へリダイレクト
        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * クイズ削除処理
     */
    public function destroy(Request $request, int $categoryId, int $quizId)
    {
      $quiz = Quiz::findOrFail($quizId);
        // まずはQuizを削除
        $quiz->delete();
        // // 次にQuizに紐づくOptionも削除
        // Option::where('quiz_id', $quizId)->delete();
        // カテゴリー詳細画面へリダイレクト
        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }
}
