document.addEventListener('DOMContentLoaded', () => {

  const editForm = document.getElementById('editForm');
  if (editForm) {
    editForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      formData.append('action', 'edit');

      fetch('admin_system/admin_qa_process.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          alert(data.message);
          closeEditModal();
          location.reload();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(() => alert('Network error'));
    });
  }

  const addForm = document.getElementById('addForm');
  if (addForm) {
    addForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      formData.append('action', 'add');

      fetch('admin_system/admin_qa_process.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          alert(data.message);
          closeAddModal();
          location.reload();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(() => alert('Network error'));
    });
  }
});

function deleteQuestion(id) {
  if (!confirm('Are you sure you want to delete this question?')) return;

  const formData = new FormData();
  formData.append('action', 'delete');
  formData.append('id', id);

  fetch('admin_system/admin_qa_process.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      alert(data.message);
      location.reload();
    } else {
      alert('Error: ' + data.message);
    }
  })
  .catch(() => alert('Network error'));
}
