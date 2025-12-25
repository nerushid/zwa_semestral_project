const dialog = document.getElementById('delete-dialog');
const cancelBtn = document.getElementById('cancel-btn');

cancelBtn.addEventListener('click', function() {
    window.location.href = '../myprofile/mylistings.php';
});

// Prevent closing dialog by clicking outside or pressing ESC
dialog.addEventListener('cancel', function(e) {
    e.preventDefault();
});
