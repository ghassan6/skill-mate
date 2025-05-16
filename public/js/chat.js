document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();  // Prevent form refresh

    const messageInput = document.getElementById('message');
    const message = messageInput.value.trim();
    if (!message) return;

    const token = document.querySelector('input[name=_token]').value;
    const recipient_id = document.querySelector('input[name=recipient_id]').value;

    fetch(this.action, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token,
        },
        body: JSON.stringify({ message, recipient_id }),
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                console.error("Server error:", text);
                throw new Error("Network response was not ok");
            });
        }
        return response.json();
    })
    .then(data => {
        console.log("Message sent:", data);
        appendMessageToChat(data.message, data.sender);

        // Clear input and scroll
        messageInput.value = '';
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    })
    .catch(error => {
        console.error("Error sending message:", error);
    });
});

function appendMessageToChat(message, sender) {
    const chatMessages = document.getElementById('chat-messages');
    const authUserId = document.getElementById('auth-user-id').value;

    // Create parent container div
    const parent = document.createElement('div');
    parent.classList.add('mb-3', 'd-flex');

    // Add alignment classes based on sender
    if (sender.id == authUserId) {
        parent.classList.add('justify-content-end');
    } else {
        parent.classList.add('justify-content-start');
    }

    // Create message bubble div
    const bubble = document.createElement('div');
    bubble.classList.add('rounded', 'p-3');
    bubble.style.maxWidth = "70%";

    // Add bg/text color classes based on sender
    if (sender.id == authUserId) {
        bubble.classList.add('bg-primary', 'text-white');
    } else {
        bubble.classList.add('bg-white', 'border');
    }

    // Create inner HTML with username, message, and timestamp placeholder
    // For timestamp, you might want to pass it in or generate current time in JS
    bubble.innerHTML = `
        <div class="small font-weight-bold ${sender.id == authUserId ? 'text-white-50' : 'text-muted'}">
            ${sender.username}
        </div>
        <p class="mb-1">${message}</p>
        <div class="text-right">
            <small class="${sender.id == authUserId ? 'text-white-50' : 'text-muted'}">
                ${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })}
            </small>
        </div>
    `;

    // Append bubble to parent, then parent to chat container
    parent.appendChild(bubble);
    chatMessages.appendChild(parent);

    // Scroll to bottom so new message is visible
    chatMessages.scrollTop = chatMessages.scrollHeight;
}


const echo = new Echo({
    broadcaster: 'pusher',
    key: window.pusherKey,
    cluster: window.pusherCluster,
    forceTLS: true,
});

echo.channel('conversation.' + window.conversationId)
    .listen('.message.sent', (e) => {
        console.log('Received message:', e);
        if (e.sender.id != document.getElementById('auth-user-id').value) {
            appendMessageToChat(e.message, e.sender);
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
