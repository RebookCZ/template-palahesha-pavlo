document.getElementById('contact').addEventListener('submit', function(e) {
    e.preventDefault();
  
    const formData = new FormData(this);
  
    fetch('submit_form.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      if (data.trim() === 'OK') {
        alert('Thank you! Your message has been sent.');
        document.getElementById('contact').reset();
      } else {
        alert('Error sending.');
      }
    })
    .catch(error => {
      alert('The server is not responding');
      console.error(error);
    });
  });