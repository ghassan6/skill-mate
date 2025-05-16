<x-layout>
    <x-slot:title>Conversation with {{ Auth::id() === $conversation->user_one_id ? $conversation->userTwo->username : $conversation->userOne->username }}</x-slot:title>

    <x-user-sidebar>
        <div class="d-flex flex-column" style="height: 100vh;">
            <!-- Conversation header -->
            <div class="bg-white border-bottom p-3 d-flex align-items-center shadow-sm">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
                    <span class="text-muted font-weight-bold">
                        {{ substr(Auth::id() === $conversation->user_one_id ? $conversation->userTwo->username : $conversation->userOne->username, 0, 1) }}
                    </span>
                </div>
                <div>
                    <h5 class="font-weight-bold mb-0">{{ Auth::id() === $conversation->user_one_id ? $conversation->userTwo->username : $conversation->userOne->username }}</h5>
                </div>
            </div>

            <!-- Messages container -->
            <div class="flex-grow-1 p-3 overflow-auto bg-light" id="chat-messages">
                @foreach($messages as $msg)
                <div class="mb-3 d-flex {{ $msg->sender_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="rounded p-3 {{ $msg->sender_id === Auth::id() ? 'bg-primary text-white' : 'bg-white border' }}"
                         style="max-width: 70%;">
                        <div class="small font-weight-bold {{ $msg->sender_id === Auth::id() ? 'text-white-50' : 'text-muted' }}">
                            {{ $msg->sender->username }}
                        </div>
                        <p class="mb-1">{{ $msg->message }}</p>
                        <div class="text-right">
                            <small class="{{ $msg->sender_id === Auth::id() ? 'text-white-50' : 'text-muted' }}">
                                {{ $msg->created_at->format('h:i A') }}
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Message input -->
            <div class="bg-white border-top p-3">
                <form id="chat-form" action="{{ route('messages.store') }}" method="POST" class="d-flex">
                    @csrf
                    <input type="hidden" name="recipient_id" value="{{ Auth::id() === $conversation->user_one_id ? $conversation->user_two_id : $conversation->user_one_id }}">

                    <input type="text" name="message" id="message" autocomplete="off"
                        class="form-control rounded-0 rounded-start"
                        placeholder="Type your message...">
                    <button type="submit"
                        class="btn btn-primary rounded-0 rounded-end">
                        Send
                    </button>
                </form>
            </div>
        </div>

        <!-- Hidden fields -->
        <input type="hidden" id="conversation-id" value="{{ $conversation->id }}">
        <input type="hidden" id="auth-user-id" value="{{ Auth::id() }}">

        <script>
            window.pusherKey = "{{ env('PUSHER_APP_KEY') }}";
            window.pusherCluster = "{{ env('PUSHER_APP_CLUSTER') }}";
            window.conversationId = {{ $conversation->id }};
        </script>
        <script src="{{asset('js/chat.js')}}"></script>
    </x-user-sidebar>
</x-layout>
