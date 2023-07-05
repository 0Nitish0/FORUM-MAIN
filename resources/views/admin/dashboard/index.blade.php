<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5 bg-indigo-100 overflow-hidden shadow-xl sm:rounded-lg">
                <div style="text-align: center;" class="text-gray-500">
                    Admin Page
                </div>
                <a href="{{ route('threads.index') }}">
                    <img src="{{ asset('img/bg/chat.jpg') }}" style="display: block; margin-left: auto; margin-right: auto; width: 50%;">
                </a>
                
            </div>
        </div>
    </div>
</x-app-layout>
