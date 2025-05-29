
document.querySelector('#openAddBtn').addEventListener('click', () => {
  openModal('addModal');
});


document.querySelector('#addModal .btn-secondary').addEventListener('click', () => {
  closeModal('addModal');
});


document.querySelector('#editModal .close').addEventListener('click', () => {
  closeModal('editModal');
});


function openEditModal(id, question, answer) {
  document.getElementById('edit-id').value = id;
  document.getElementById('edit-question').value = question;
  document.getElementById('edit-answer').value = answer;
  openModal('editModal');
}

document.getElementById('addForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('question_api.php?action=add', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.success) {
      closeModal('addModal');
      loadQuestions();
      this.reset();
    }
  })
  .catch(err => alert('Ошибка сервера: ' + err.message));
});


document.getElementById('editForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('question_api.php?action=edit', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.success) {
      closeModal('editModal');
      loadQuestions();
    }
  })
  .catch(err => alert('Ошибка сервера: ' + err.message));
});

function deleteQuestion(id) {
  if (!confirm('Вы уверены, что хотите удалить этот вопрос?')) return;

  fetch('question_api.php?action=delete&id=' + id)
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      if (data.success) {
        loadQuestions();
      }
    })
    .catch(err => alert('Ошибка сервера: ' + err.message));
}

window.onclick = function(event) {
  const addModal = document.getElementById('addModal');
  const editModal = document.getElementById('editModal');
  if (event.target === addModal) closeModal('addModal');
  if (event.target === editModal) closeModal('editModal');

  const signupModal = document.getElementById('signupModal');
  const loginModal = document.getElementById('loginModal');
  if (event.target === signupModal) closeModal('signupModal');
  if (event.target === loginModal) closeModal('loginModal');
};

function loadQuestions() {
  fetch('question_api.php?action=list')
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        alert('Ошибка загрузки вопросов: ' + data.message);
        return;
      }
      const tbody = document.querySelector('table tbody');
      tbody.innerHTML = '';

      data.questions.forEach(q => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
          <td>${q.ID}</td>
          <td>${escapeHtml(q.otazka)}</td>
          <td>${escapeHtml(q.odpoved)}</td>
          <td>
            <button class="btn btn-warning btn-sm" onclick="openEditModal(${q.ID}, '${escapeJs(q.otazka)}', '${escapeJs(q.odpoved)}')">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="deleteQuestion(${q.ID})">Delete</button>
          </td>
        `;

        tbody.appendChild(tr);
      });
    })
    .catch(err => alert('Ошибка сервера: ' + err.message));
}


function escapeHtml(text) {
  return text.replace(/[&<>"']/g, function(m) {
    return {'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[m];
  });
}
function escapeJs(text) {
  return text.replace(/'/g, "\\'").replace(/\n/g, '\\n').replace(/\r/g, '');
}

document.addEventListener('DOMContentLoaded', loadQuestions);
