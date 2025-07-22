<x-play-layout>


<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-20">
      <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">
        @if ($isCorrectAnswer)
          正解です⭐彡
        @else
          残念、不正解です😢
        @endif
      </h1>
      <p class="lg:w-2/3 mx-auto leading-relaxed text-base">問題：{{ $quiz->question }}</p>
      <p class="lg:w-2/3 mx-auto leading-relaxed text-base">解説：{{ $quiz->explanation }}</p>
    </div>


        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
          <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
              <tr>
                <th class="whitespace-nowrap w-20 px-4 py-3 title-font tracking-wider
                font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                  番号</th>
                <th class="whitespace-nowrap px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">選択肢</th>
                <th class="whitespace-nowrap px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">正解or不正解</th>
                <th class="whitespace-nowrap px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">あたなの解答</th>
              </tr>
            </thead>
            <tbody>

              @for ($i = 0; $i < 4; $i++)
                <tr>
                  <td class="px-4 py-3 w-20">{{ $i + 1 }}</td>
                  <td class="px-4 py-3">{{ $quizOptions[$i]['content'] }}</td>
                  <td class="px-4 py-3">{{ $quizOptions[$i]['is_correct'] ? '〇' : '×' }}</td>
                  <td class="px-4 py-3">{{ in_array($quizOptions[$i]['id'], $selectedOptions) ? '〇' : '×' }} </td>
                </tr>
              @endfor


            </tbody>
          </table>
        </div>
        <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
          <button
            onclick="location.href='{{ route('categories.quizzes', ['categoryId' => $categoryId]) }}'"
            class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
            次の問題へ
          </button>
        </div>

  </div>
</section>
</x-play-layout>
