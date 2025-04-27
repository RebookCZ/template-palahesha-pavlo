function deleteQuestion(id) {
    if (confirm('Are you sure you want to delete this question?')) {
        fetch('users_db/delete_question.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Question deleted successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Server error: ' + error.message);
            });
    }
}