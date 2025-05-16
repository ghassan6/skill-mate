// // echo.js - Complete debugging and fixed implementation

// document.addEventListener('DOMContentLoaded', function() {
//     console.log('DOM loaded, initializing Echo listeners');

//     // Check if we're on a conversation page
//     const chatMessages = document.getElementById('chat-messages');
//     const chatForm = document.getElementById('chat-form');
//     const conversationIdElement = document.getElementById('conversation-id');
//     const authUserIdElement = document.getElementById('auth-user-id');

//     if (!chatMessages || !chatForm || !conversationIdElement || !authUserIdElement) {
//         console.log('Not on a chat page or missing required elements');
//         return;
//     }

//     const conversationId = conversationIdElement.value;
//     const authUserId = authUserIdElement.value;

//     console.log(`Chat page detected. Conversation ID: ${conversationId}, Auth User ID: ${authUserId}`);

//     // Debug Pusher connection and channels
//     if (window.Echo.connector.pusher) {
//         const pusher = window.Echo.connector.pusher;

//         pusher.connection.bind('state_change', function(states) {
//             console.log(`Pusher connection state changed from '${states.previous}' to '${states.current}'`);
//         });

//         // Listen for all events (debug)
//         pusher.bind_global(function(eventName, data) {
//             console.log(`Global Pusher event received: ${eventName}`, data);
//         });
//     }

//     // OPTION 1: Listen on the specific channel with specific event name (Laravel's default format)
//     window.Echo.channel(`conversation.${conversationId}`)
//         .listen('.MessageSent', (data) => {
//             console.log('✅ EVENT RECEIVED with .MessageSent format!', data);
//             addMessageToChat(data, authUserId, chatMessages);
//         });

//     // OPTION 2: Listen on the specific channel with the custom event name format
//     window.Echo.channel(`conversation.${conversationId}`)
//         .listen('.message.sent', (data) => {
//             console.log('✅ EVENT RECEIVED with .message.sent format!', data);
//             addMessageToChat(data, authUserId, chatMessages);
//         });

//     // OPTION 3: Listen on the specific channel with App namespace format
//     window.Echo.channel(`conversation.${conversationId}`)
//         .listen('App\\Events\\MessageSent', (data) => {
//             console.log('✅ EVENT RECEIVED with full namespace format!', data);
//             addMessageToChat(data, authUserId, chatMessages);
//         });

//     // Handle form submission via Ajax
//     chatForm.addEventListener('submit', function(e) {
//         e.preventDefault();
//         console.log('Form submitted');

//         const messageInput = document.getElementById('message');
//         const message = messageInput.value;

//         if (message.trim() === '') {
//             console.log('Empty message, not sending');
//             return;
//         }

//         console.log(`Sending message: "${message}" to ${chatForm.action}`);

//         // Get the CSRF token
//         const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//         axios.post(chatForm.action, {
//             message: message,
//             _token: token
//         })
//         .then(response => {
//             console.log('Message sent successfully:', response.data);

//             // Option 4: Immediately add the message locally
//             // This ensures at least the sender sees their message without refresh
//             const messageData = response.data;
//             if (messageData && messageData.id) {
//                 addMessageToChat({
//                     id: messageData.id,
//                     sender_id: authUserId,
//                     sender: {
//                         id: authUserId,
//                         username: document.getElementById('auth-username') ?
//                                   document.getElementById('auth-username').value : 'You'
//                     },
//                     message: message,
//                     created_at: new Date().toISOString()
//                 }, authUserId, chatMessages);
//             }

//             messageInput.value = '';
//         })
//         .catch(error => {
//             console.error('Error sending message:', error);
//         });
//     });

//     // Scroll to bottom initially
//     scrollToBottom(chatMessages);
// });

// function addMessageToChat(data, authUserId, chatMessages) {
//     console.log(`Adding message to chat. Sender ID: ${data.sender_id}, Auth User ID: ${authUserId}`);

//     // Prevent duplicate messages by checking if this message already exists
//     const existingMessages = chatMessages.querySelectorAll('p');
//     for (let i = 0; i < existingMessages.length; i++) {
//         if (existingMessages[i].textContent === data.message &&
//             existingMessages[i].dataset.messageId === String(data.id)) {
//             console.log('Message already exists in chat, not adding duplicate');
//             return;
//         }
//     }

//     // Create new message element
//     const messageDiv = document.createElement('div');
//     messageDiv.className = `mb-2 ${parseInt(data.sender_id) === parseInt(authUserId) ? 'text-end' : ''}`;

//     const senderSpan = document.createElement('small');
//     senderSpan.className = 'text-muted';
//     senderSpan.textContent = data.sender.username + ':';

//     const messageP = document.createElement('p');
//     messageP.textContent = data.message;
//     messageP.dataset.messageId = data.id; // Store message ID to prevent duplicates

//     messageDiv.appendChild(senderSpan);
//     messageDiv.appendChild(messageP);

//     // Add new message to chat container
//     chatMessages.appendChild(messageDiv);

//     // Scroll to the bottom of the chat
//     scrollToBottom(chatMessages);
//     console.log('Message added to chat and scrolled to bottom');
// }

// function scrollToBottom(container) {
//     container.scrollTop = container.scrollHeight;
// }
