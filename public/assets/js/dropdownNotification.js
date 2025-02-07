// Fungsi baca pesan
document.querySelectorAll('.notification-item').forEach(item => {
    item.addEventListener('click', () => {
        item.classList.remove('highlight');
    });
});

// Fungsi baca semua
document.getElementById('mark-read').addEventListener('click', () => {
    document.querySelectorAll('.notification-item').forEach(item => {
        item.classList.remove('highlight');
    });

    // Send an AJAX request to mark all notifications as read
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Laravel CSRF token
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            mark_all: true
        })
    })
    .then(response => response.json())
    .then(data => {
        // You can do something with the response, e.g., show a success message
        console.log('All notifications marked as read');
        updateUnreadCount(true);
    })
    .catch(error => {
        console.error('Error marking notifications as read:', error);
    });
});

// Fungsi biar ga nutup dropdown
document.querySelectorAll('.dclose').forEach(item => {
    item.addEventListener('click', (event) => {
        event.stopPropagation();
    });
});

// Attach event listeners to all notifications
document.querySelectorAll('.notification-item').forEach(function (notification) {
    notification.addEventListener('click', function () {
        const notificationId = this.getAttribute('data-notification-id');

        // Send an AJAX request to mark the notification as read
        fetch(`/notifications/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                // You can send additional data here if needed
            })
        })
        .then(response => response.json())
        .then(data => {
            // On success, add the 'read' class to visually mark it as read
            if (data.success) {
                notification.classList.remove('highlight'); // Remove highlight class (if any)
                notification.classList.add('read'); // Optionally, you can add a 'read' class for styling

                // Update the unread notification count
                updateUnreadCount(false);
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    });
});

// Function to update the unread notification count and hide the badge if zero
function updateUnreadCount(allRead) {
    // Update the count in the badge
    const countBadge = document.getElementById('unread-notification-count');
    if (countBadge) {
        let unreadCount = parseInt(countBadge.textContent.trim(), 10);
        countBadge.textContent = unreadCount - 1;

        // If no unread notifications, hide the badge
        if ((unreadCount - 1) === 0 || allRead) {
            countBadge.style.display = 'none';
        } else {
            countBadge.style.display = 'block';
        }
    }
}