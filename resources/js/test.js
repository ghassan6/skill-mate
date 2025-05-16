// test-echo.js - Place this in your resources/js folder

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, running Echo test...');

    // First check if Echo exists
    if (typeof window.Echo === 'undefined') {
        console.error('ERROR: window.Echo is not defined. Echo is not properly initialized.');
        return;
    }

    console.log('✅ Echo is defined');

    // Check if Pusher is initialized
    if (typeof window.Pusher === 'undefined') {
        console.error('ERROR: window.Pusher is not defined. Pusher is not properly loaded.');
        return;
    }

    console.log('✅ Pusher is defined');

    // Check Echo connector
    if (!window.Echo.connector) {
        console.error('ERROR: Echo connector is not defined.');
        return;
    }

    console.log('✅ Echo connector exists:', window.Echo.connector.constructor.name);

    // Check if the connector is Pusher
    if (window.Echo.connector.constructor.name !== 'PusherConnector') {
        console.error('ERROR: Echo is not using Pusher connector. Current connector:', window.Echo.connector.constructor.name);
        return;
    }

    console.log('✅ Echo is using Pusher connector');

    // Check socket ID
    const socketId = window.Echo.socketId();
    console.log('Current socket ID:', socketId || 'Not connected yet');

    // Test Pusher connection
    const pusher = window.Echo.connector.pusher;
    console.log('Pusher connection state:', pusher.connection.state);

    // Subscribe to a test channel
    console.log('Attempting to subscribe to a test channel...');
    try {
        const channel = window.Echo.channel('test-channel');
        console.log('✅ Successfully subscribed to test channel');

        // Listen for a test event
        channel.listen('test-event', function(data) {
            console.log('Received test event:', data);
        });
        console.log('✅ Added listener for test-event');
    } catch (error) {
        console.error('ERROR subscribing to channel:', error);
    }

    console.log('Echo test complete');
});
