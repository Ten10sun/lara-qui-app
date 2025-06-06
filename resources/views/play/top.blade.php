<x-play-layout>


  <section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-wrap w-full mb-20">
      <div class="w-full mb-6 lg:mb-0">
        <h1 class="text-center sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">カテゴリーを選択してください</h1>
        <div class="mx-auto h-1 w-20 bg-indigo-500 rounded"></div>
      </div>
    </div>

    <div class="flex flex-wrap -m-4 justify-center">
      @foreach ($categories as $category)
      <div class="p-4 w-full sm:w-1/2 lg:w-1/2 xl:w-2/5">
        <a href="{{ route('categories', ['categoryId' => $category->id]) }}" class="block bg-gray-100 p-6 rounded-lg h-full">
          <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $category->name }}</h2>
          <p class="leading-relaxed text-base">{{ $category->description }}</p>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>
  
  
</x-play-layout>