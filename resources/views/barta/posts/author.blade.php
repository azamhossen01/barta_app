@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
  <!-- Cover Container -->
  <section
    class="bg-white border-2 p-8 border-gray-800 rounded-xl min-h-[350px] space-y-8 flex items-center flex-col justify-center">
    <!-- Profile Info -->
    <div class="flex gap-4 justify-center flex-col text-center items-center">
      <!-- Avatar -->
      <div class="relative">
        <img class="w-32 h-32 rounded-full border-2 border-gray-800"
          src="{{ $user->getFirstMediaUrl('avatar') }}" alt="Ahmed Shamim" />
        <!--            <span class="bottom-2 right-4 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>-->
      </div>
      <!-- /Avatar -->

      <!-- User Meta -->
      <div>
        <h1 class="font-bold md:text-2xl">{{ $user->name }}</h1>
        <p class="text-gray-700">{{ $user->bio }}</p>
      </div>
      <!-- / User Meta -->
    </div>
    <!-- /Profile Info -->

    <!-- Profile Stats -->
    <div class="flex flex-row gap-16 justify-center text-center items-center">
      <!-- Total Posts Count -->
      <div class="flex flex-col justify-center items-center">
        <h4 class="sm:text-xl font-bold">{{ $user->posts->count() }}</h4>
        <p class="text-gray-600">Posts</p>
      </div>

      <!-- Total Comments Count -->
      <div class="flex flex-col justify-center items-center">
        <h4 class="sm:text-xl font-bold">{{ $user->posts->sum('comments_count') }}</h4>
        <p class="text-gray-600">Comments</p>
      </div>
    </div>
    <!-- /Profile Stats -->

   @if ($user->id === Auth::id())
        <!-- Edit Profile Button (Only visible to the profile owner) -->
    <a href="{{ route('profile.edit') }}" type="button"
    class="-m-2 flex gap-2 items-center rounded-full px-4 py-2 font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
      class="w-5 h-5">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
    </svg>

    Edit Profile
  </a>
   @endif
    <!-- /Edit Profile Button -->
  </section>
  <!-- /Cover Container -->

 @if (Auth::id() === $user->id)
       <!-- Barta Create Post Card -->
  <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data"
  class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3">
  @csrf 
  <!-- Create Post Card Top -->
  <div>
    <div class="flex items-start /space-x-3/">
      <!-- User Avatar -->
      <div class="flex-shrink-0">
        <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->getFirstMediaUrl('avatar', 'thumb') }}"
          alt="{{ $user->name }}" />
      </div>
      <!-- /User Avatar -->

      <!-- Content -->
      <div class="text-gray-700 font-normal w-full">
        <textarea
          class="block w-full p-2 pt-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
          name="description" rows="2" placeholder="What's going on, {{ $user->name }}?"></textarea>
          @error('description')
              <small class="text-red-500">{{ $message }}</small>
          @enderror
          @error('featured_image')
              <small class="text-red-500">{{ $message }}</small>
          @enderror
      </div>
    </div>
  </div>

  <!-- Create Post Card Bottom -->
  <div>
    <!-- Card Bottom Action Buttons -->
    <div class="flex items-center justify-between">
      <div class="flex gap-4 text-gray-600">
        <!-- Upload Picture Button -->
        <div>
          <input type="file" name="featured_image" id="picture" class="hidden" />

          <label for="picture"
            class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800 cursor-pointer">
            <span class="sr-only">Picture</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
          </label>
        </div>
      
      </div>

      <div>
        <!-- Post Button -->
        <button type="submit"
          class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
          Post
        </button>
        <!-- /Post Button -->
      </div>
    </div>
    <!-- /Card Bottom Action Buttons -->
  </div>
  <!-- /Create Post Card Bottom -->
</form>
<!-- /Barta Create Post Card -->
 @endif

  <!-- User Specific Posts Feed -->
  <!-- Barta Card -->
  @forelse ($user->posts as $post)
  <article
  class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
  <!-- Barta Card Top -->
  <header>
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <!-- User Avatar -->
          <div class="flex-shrink-0">
            <img
              class="h-10 w-10 rounded-full object-cover"
              src="{{ $post->user->getFirstMediaUrl('avatar', 'thumb') }}"
              alt="Al Nahian" />
          </div>
        <!-- /User Avatar -->

        <!-- User Info -->
        <div class="text-gray-900 flex flex-col min-w-0 flex-1">
          <a
            href="{{ route('author_profile', Crypt::encrypt($post->user->username)) }}"
            class="hover:underline font-semibold line-clamp-1">
            {{ $post->user->name }}
          </a>

          <a
            href="{{ route('author_profile', Crypt::encrypt($post->user->username)) }}"
            class="hover:underline text-sm text-gray-500 line-clamp-1">
            {{ $post->user->username }}
          </a>
        </div>
        <!-- /User Info -->
      </div>

      @if (Auth::id() === $post->user_id)
          <!-- Card Action Dropdown -->
      <div
      class="flex flex-shrink-0 self-center"
      x-data="{ open: false }">
      <div class="relative inline-block text-left">
        <div>
          <button
            @click="open = !open"
            type="button"
            class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
            id="menu-0-button">
            <span class="sr-only">Open options</span>
            <svg
              class="h-5 w-5"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true">
              <path
                d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z"></path>
            </svg>
          </button>
        </div>
            <!-- Dropdown menu -->
        <div
        x-show="open"
        @click.away="open = false"
        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="user-menu-button"
        tabindex="-1">
        <a
          href="{{ route('posts.edit', $post->uuid) }}"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
          role="menuitem"
          tabindex="-1"
          id="user-menu-item-0"
          >Edit</a
        >
        @include('components.confirm-delete', ['uuid' => $post->uuid, 'deleteRoute' => route('posts.destroy', $post->uuid)])
      </div>
      </div>
    </div>
    <!-- /Card Action Dropdown -->
      @endif
    </div>
  </header>

  <!-- Content -->
  <a href="{{ route('posts.show', $post->uuid) }}">
    @if ($post->hasMedia('featured_image'))
    <div class="py-4 text-gray-700 font-normal space-y-2">
        <img
          src="{{ $post->getFirstMediaUrl('featured_image') }}"
          class="min-h-auto w-full rounded-lg object-cover max-h-64 md:max-h-72"
          alt="" />
    </div>
    @endif
    
    <div class="py-4 text-gray-700 font-normal">
      {{ Str::words($post->description, 20, '...') }}
    </div>
  </a>

  <!-- Date Created & View Stat -->
  <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
    <span class="">{{ $post->created_at->diffForHumans() }}</span>
    <span class="">•</span>
    <span>450 views</span>
  </div>

  <!-- Barta Card Bottom -->
  <footer class="border-t border-gray-200 pt-2">
    <!-- Card Bottom Action Buttons -->
    <div class="flex items-center justify-between">
      <div class="flex gap-8 text-gray-600">
        <!-- Comment Button -->
        <a
          href="./single.html"
          type="button"
          class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
          <span class="sr-only">Comment</span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="w-5 h-5">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
          </svg>

          <p>{{ $post->comments->count() }}</p>
        </a>
        <!-- /Comment Button -->
      </div>
    </div>
    <!-- /Card Bottom Action Buttons -->
  </footer>
  <!-- /Barta Card Bottom -->
</article>
  @empty
      
  @endforelse
  <!-- /Barta Card -->
  <!-- User Specific Posts Feed -->
</main>
@endsection
