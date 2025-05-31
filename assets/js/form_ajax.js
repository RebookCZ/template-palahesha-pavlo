document.getElementById('contactForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch('submit_form.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.text();

        if (!response.ok) throw new Error(result);

        alert(result);
        setTimeout(() => {
            window.location.reload();
        }, 500);

    } catch (error) {
        alert('Error: ' + error.message);
    }
});
