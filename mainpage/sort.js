document.addEventListener('DOMContentLoaded', function() {
    const sortSelect = document.getElementById('sort-selectid');
    const hiddenSortInput = document.getElementById('hidden-sort');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            // Update the sort parameter
            urlParams.set('sort', this.value);
            
            // Reset to page 1 when sorting changes
            urlParams.set('page', '1');
            
            // Update hidden input in the filter form
            if (hiddenSortInput) {
                hiddenSortInput.value = this.value;
            }
            
            // Redirect to the new URL with updated sort parameter
            window.location.href = '?' + urlParams.toString();
        });
    }
});
