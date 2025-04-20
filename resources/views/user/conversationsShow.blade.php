<x-layout>
<x-slot:title>Conve</x-slot:title>
<x-user-sidebar>
    <h1>Your Conversations</h1>
    <h1>Chat with {{ Auth::id() === $conversation->user_one_id ? $conversation->userTwo->username : $conversation->userOne->username }}</h1>

    <div class="border p-3 mb-4" id="chat-messages" style="height: 400px; overflow-y: scroll;">
        @foreach($messages as $msg)
        <div class="mb-2 {{ $msg->sender_id === Auth::id() ? 'text-end' : '' }}">
            <small class="text-muted">{{ $msg->sender->username }}:</small>
            <p>{{ $msg->message }}</p>
        </div>
        @endforeach
    </div>

    <form action="{{route('conversations.messages.store', $conversation)}}" method="POST">
        @csrf
        <input type="text" name="message" id="message">
        <button>Send</button>
    </form>

    <!-- Add this script section -->

    <!-- At the bottom of your file, before closing body tag -->
@vite(['resources/js/app.js'])
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll to bottom of chat on page load
        const chatContainer = document.getElementById('chat-messages');
        chatContainer.scrollTop = chatContainer.scrollHeight;

        const conversationId = {{ $conversation->id }};

        // Make sure Echo is properly initialized
        if (typeof Echo !== 'undefined') {
            console.log('Echo initialized, subscribing to channel...');

            Echo.channel(`conversation.${conversationId}`)
                .listen('.message.sent', (data) => {
                    console.log('New message received:', data);

                    const isCurrentUser = data.sender_id === {{ Auth::id() }};
                    const messageClass = isCurrentUser ? 'text-end' : '';

                    const messageHtml = `
                        <div class="mb-2 ${messageClass}">
                            <small class="text-muted">${data.sender?.username || 'User'}:</small>
                            <p>${data.message}</p>
                        </div>
                    `;

                    chatContainer.insertAdjacentHTML('beforeend', messageHtml);
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                });
        } else {
            console.error('Echo is not defined. Check your JavaScript setup.');
        }
    });
    </script>
</x-user-sidebar>
</x-layout>
