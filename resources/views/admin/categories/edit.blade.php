<x-admin-layout>

<section class="text-gray-600 body-font relative">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-12">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">カテゴリー編集</h1>
    </div>
    <div class="lg:w-1/2 md:w-2/3 mx-auto">

      <form method="post" action="{{ route('admin.categories.update', [$category->id]) }}" class="flex flex-wrap -m-2">
        @csrf
        <div class="p-2 w-full">
          <div class="relative">
            <label for="name" class="leading-7 text-sm text-gray-600">カテゴリー名</label>
            <input type="text" id="name" name="name" value="{{ is_null(old('name')) ? $category->name : old('name') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
          </div>
          <!-- カテゴリー名のバリデーションエラーメッセージの表示 -->
          @error('name')
          <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
          @enderror
        </div>
        <div class="p-2 w-full">
          <div class="relative">
            <label for="description" class="leading-7 text-sm text-gray-600">カテゴリー説明文</label>
            <textarea id="description" name="description" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
            >{{ is_null(old('description')) ? $category->description : old('description') }}</textarea>
          </div>
          <!-- カテゴリー説明文のバリデーションエラーメッセージの表示 -->
          @error('description')
          <p class="text-red-500 text-lg italic mt-2">{{ $message }}</p>
          @enderror
        </div>
        <div class="p-2 w-full">
          <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
            更新
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

</x-admin-layout>