<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
?>
<section class="admin-panel mt-5 mb-5">
    <div class="container">
        <h3>Control panel</h3>
        <p>You can edit or delete the questions</p>
    </div>
</section>

<script>
function deleteQuestion(id) {
    if (confirm('Are you sure?')) {
        fetch('users_db/delete_question.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Success!');
                    window.location.reload();
                } else {
                    alert('Error deleting');
                }
            })
            .catch(error => {
                console.error('Error request', error);
            });
    }
}
</script>
<?php
}
?>
