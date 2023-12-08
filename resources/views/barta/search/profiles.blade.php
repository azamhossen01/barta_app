@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
    <!-- Cover Container -->
    <section
      class="bg-white border-2  border-gray-800 rounded-xl min-h-[350px] space-y-8 flex items-center flex-col justify-center">

      <div class="container mx-auto p-8">
        <div class="max-w-2xl mx-auto bg-white p-4 shadow-md rounded-md">
            <h2 class="text-2xl font-bold mb-4">Search Results</h2>

            <!-- Example search result item -->
            @forelse ($users as $user)
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-16 h-16 rounded-full overflow-hidden">
                    <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') }}" alt="Profile Image" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <p class="text-lg font-semibold">{{ $user->name }}</p>
                    <p class="text-gray-500">{{ $user->email }}</p>
                </div>
                <a href="{{ route('author_profile', Crypt::encrypt($user->username)) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Go to Profile</a>
            </div>
            @empty
                
            @endforelse

            <!-- Repeat the above block for each search result item -->

            <!-- Pagination links -->
            <div class="flex justify-end">
                {{-- <a href="#" class="text-blue-500">Previous</a>
                <span class="mx-2">|</span>
                <a href="#" class="text-blue-500">Next</a> --}}
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>

    </section>
    
</main>
@endsection