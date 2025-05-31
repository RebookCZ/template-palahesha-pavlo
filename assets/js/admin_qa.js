function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}

function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

function openEditModal(id, question, answer) {
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-question').value = question;
    document.getElementById('edit-answer').value = answer;
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

window.onclick = function(event) {
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    if (event.target === addModal) {
        closeAddModal();
    }
    if (event.target === editModal) {
        closeEditModal();
    }
}
