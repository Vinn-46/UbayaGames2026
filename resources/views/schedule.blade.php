@extends('layouts.app')
@section('content')
    <div class="flex flex-col min-h-[calc(100vh-130px)] w-full">
        <div class="flex-grow flex items-center justify-center px-4">
            <div class="text-center animate-pulse">
                <h1
                    class="text-4xl sm:text-5xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-b from-yellow-300 to-yellow-700 uppercase tracking-widest font-heading mb-6 py-4 leading-relaxed">
                    Coming Soon
                </h1>
                <div class="w-24 h-1 bg-yellow-500/50 mx-auto rounded-full"></div>
            </div>
        </div>
        <div class="w-full mt-auto shrink-0 z-20 relative">
            @include('layouts.footer')
        </div>
    </div>
@endsection
