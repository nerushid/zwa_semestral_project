document.addEventListener('DOMContentLoaded', () => {
    const sortSelect = document.getElementById('sort-select');
    const filterForm = document.querySelector('#filters-section form'); 

    if (sortSelect && filterForm) {
        
        const injectSortAndSubmit = (submitNow = false) => {
            const selectedSort = sortSelect.value;

            let hiddenInput = filterForm.querySelector('input[name="sort"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'sort';
                filterForm.appendChild(hiddenInput);
            }

            hiddenInput.value = selectedSort;

            if (submitNow) {
                const pageInput = filterForm.querySelector('input[name="page"]');
                if (pageInput) pageInput.remove();
                
                filterForm.submit();
            }
        };

        sortSelect.addEventListener('change', function() {
            injectSortAndSubmit(true);
        });

        filterForm.addEventListener('submit', function() {
            injectSortAndSubmit(false);
        });
    }

    // Reset filters button
    const resetButton = document.getElementById('reset-filters');
    if (resetButton) {
        resetButton.addEventListener('click', () => {
            window.location.href = window.location.pathname;
        });
    }
});