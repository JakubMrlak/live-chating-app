let currentRoom = null;
let currentRecipient = null;

function initializeChat(userId) {
    console.log('Initializing chat for userId:', userId);
    loadUsers(userId);

    document.getElementById('generateRoom').addEventListener('click', generateRoom);
    document.getElementById('joinRoom').addEventListener('click', joinRoom);
    document.getElementById('sendMessage').addEventListener('click', sendMessage);
    document.getElementById('logout').addEventListener('click', (event) => {
        event.preventDefault();
        console.log('Logout clicked');
        logout();
    });

    setInterval(() => loadMessages(), 2000);
}

function loadUsers(userId) {
    fetch('../php/get_users.php')
        .then(response => response.json())
        .then(users => {
            const peopleDiv = document.querySelector('.users'); // Changed from .people_list to .users
            if (!peopleDiv) {
                console.error('users div not found in the DOM');
                return;
            }
            peopleDiv.innerHTML = '';
            users.forEach(user => {
                if (user.User_id !== userId) {
                    const btn = document.createElement('button');
                    btn.textContent = user.Name;
                    btn.className = 'single_user'; // Updated class name as per your file
                    btn.addEventListener('click', () => selectUser(user.User_id));
                    peopleDiv.appendChild(btn);
                    // Removed extra <br> to avoid clutter (optional, add back if needed)
                }
            });
        })
        .catch(error => {
            console.error('Error fetching users:', error);
        });
}

function selectUser(userId) {
    currentRecipient = userId;
    currentRoom = null;
    document.getElementById('messages').innerHTML = '';
    document.getElementById('generatedKey').textContent = '';
    document.getElementById('roomKeyInput').value = ''; // Clear the input on user selection
}

function generateRoom() {
    if (!currentRecipient) {
        alert('Please select a user first');
        return;
    }
    const roomKeyInput = document.getElementById('roomKeyInput').value.trim();
    if (!roomKeyInput) {
        alert('Please enter a room key to create the room');
        return;
    }

    fetch('../php/generate_room.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `recipient=${currentRecipient}&key=${roomKeyInput}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentRoom = roomKeyInput; // Use the input key as currentRoom
            document.getElementById('roomKeyInput').value = ''; // Clear the input after success
            loadMessages();
        } else {
            alert('Failed to generate room: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error generating room:', error);
    });
}

function joinRoom() {
    if (!currentRecipient) {
        alert('Please select a user first');
        return;
    }
    const key = document.getElementById('roomKey').value.trim();
    if (!key) {
        alert('Please enter a room key to join');
        return;
    }
    fetch('../php/join_room.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `recipient=${currentRecipient}&key=${key}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentRoom = key; // Use the input key as currentRoom
            loadMessages();
        } else {
            alert('Invalid key');
        }
    })
    .catch(error => {
        console.error('Error joining room:', error);
    });
}

function loadMessages() {
    if (!currentRoom) return;
    fetch(`../php/get_messages.php?room=${currentRoom}`)
        .then(response => response.text())
        .then(messages => {
            document.getElementById('messages').innerHTML = messages;
        })
        .catch(error => {
            console.error('Error loading messages:', error);
        });
}

function sendMessage() {
    const message = document.getElementById('messageInput').value;
    if (!currentRoom || !message) return;
    fetch('../php/send_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `room=${currentRoom}&message=${message}`
    })
    .then(() => {
        document.getElementById('messageInput').value = '';
        loadMessages();
    })
    .catch(error => {
        console.error('Error sending message:', error);
    });
}

function logout() {
    console.log('Attempting logout...');
    fetch('../php/logout.php', {
        method: 'POST'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Logout request failed: ' + response.statusText);
        }
        console.log('Logout successful, redirecting...');
        window.location = '../index.php';
    })
    .catch(error => {
        console.error('Logout error:', error);
        alert('Logout failed. Please try again or check the console for details.');
    });
}