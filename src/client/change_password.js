document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        changePassword();
    });
});

function changePassword() {
    const formData = new FormData(document.getElementById('changePasswordForm'));

    fetch('change_password.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Password changed successfully.');
        } else {
            alert(data.message);
        }
    });
}
