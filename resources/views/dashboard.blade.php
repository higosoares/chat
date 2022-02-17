@section('style')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('scripts')
    <script src="{{ asset('js/pusher.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}" defer></script>
    <script src="{{ asset('js/chat.js') }}" defer></script>
    <script src="{{ asset('js/index.js') }}" defer></script>
    <script>
        const auth_user = "{{ auth()->id() }}";
    </script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex content">
                        <div class="users-wrapper">
                            <x-messages.users.users :users="$users" />
                        </div>
                        <div class="messages-wrapper hidden">
                            <x-messages.messages />
                            <x-messages.input />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
