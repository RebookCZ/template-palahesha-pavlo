function openAddModal() {
    document.getElementById('addModal').style.display = 'block';
}

function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    console.log("Script loaded");

    const form = document.getElementById('addForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('users_db/add_question.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log("Raw response:", response);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Question added successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Server error: ' + error.message);
            });
        });
    } else {
        console.error("Form not found");
    }
});
