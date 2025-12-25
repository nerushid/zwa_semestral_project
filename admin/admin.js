const dialog = document.getElementById('confirm-dialog');
const dialogTitle = document.getElementById('dialog-title');
const dialogMessage = document.getElementById('dialog-message');
const confirmForm = document.getElementById('confirm-form');
const actionInput = document.getElementById('action-input');
const targetIdInput = document.getElementById('target-id-input');
const cancelBtn = dialog.querySelector('.cancel-btn');

// Tab switching
const tabBtns = document.querySelectorAll('.tab-btn');
tabBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        const tab = this.dataset.tab;
        window.location.href = '?tab=' + tab;
    });
});

// Action buttons
document.addEventListener('click', function(e) {
    const target = e.target;
    
    if (target.dataset.action) {
        e.preventDefault();
        const action = target.dataset.action;
        const id = target.dataset.id;
        const name = target.dataset.name;
        
        let title, message;
        
        switch(action) {
            case 'delete_user':
                title = 'Delete User';
                message = `Are you sure you want to delete user "${name}"? This will also delete all their listings.`;
                break;
            case 'make_admin':
                title = 'Make Admin';
                message = `Are you sure you want to make "${name}" an admin?`;
                break;
            case 'remove_admin':
                title = 'Remove Admin';
                message = `Are you sure you want to remove admin privileges from "${name}"?`;
                break;
            case 'delete_listing':
                title = 'Delete Listing';
                message = `Are you sure you want to delete listing "${name}"?`;
                break;
            default:
                return;
        }
        
        dialogTitle.textContent = title;
        dialogMessage.textContent = message;
        actionInput.value = action;
        targetIdInput.value = id;
        
        dialog.showModal();
    }
});

// Cancel button
cancelBtn.addEventListener('click', function() {
    dialog.close();
});

// Prevent dialog from closing on backdrop click
dialog.addEventListener('cancel', function(e) {
    e.preventDefault();
});
