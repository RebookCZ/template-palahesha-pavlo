document.getElementById('signupForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('action', 'register');

    fetch('users_db/auth.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Registration success!');
            closeModal('signupModal');
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Server error.');
    });
});

document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('action', 'login');

    fetch('users_db/auth.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Login success!');
            closeModal('loginModal');
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Server error.');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const logoutBtn = document.getElementById('logoutButton');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function () {
            const formData = new FormData();
            formData.append('action', 'logout');

            fetch('users_db/auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/template-palahesha-pavlo/index.php';
                } else {
                    alert('Logout failed');
                }
            })
            .catch(error => {
                console.error('Logout error:', error);
                alert('Server error during logout.');
            });
        });
    }
});
