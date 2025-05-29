
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'block';
  }
}


function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}


function switchModal(oneId, anotherId) {
  closeModal(oneId);
  openModal(anotherId);
}


window.onclick = function(event) {
  const signupModal = document.getElementById('signupModal');
  const loginModal = document.getElementById('loginModal');

  if (event.target === signupModal) {
    closeModal('signupModal');
  } else if (event.target === loginModal) {
    closeModal('loginModal');
  }
};
