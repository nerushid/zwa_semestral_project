document.addEventListener("DOMContentLoaded", () => {
    const filterForm = document.querySelector("#filters-section form");
    const resultsContainer = document.getElementById("listings-and-pagination");
    const resetButton = document.getElementById("reset-filters");

    function getSortValue() {
        const select = document.getElementById("sort-select");
        return select ? select.value : 'newest';
    }

    function loadListings(urlParams) {
        if (!resultsContainer) {
            console.error("Container #listings-and-pagination not found!");
            return;
        }

        resultsContainer.style.opacity = "0.5";

        fetch(`includes/ajax_load_listings.php?${urlParams.toString()}`)
            .then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.text();
            })
            .then(html => {
                resultsContainer.innerHTML = html;
                resultsContainer.style.opacity = "1";
                // After inserting new HTML, sync UI and re-initialize dynamic parts

                // 0) Re-initialize image sliders for new listings
                if (typeof initImageSliders === 'function') {
                    initImageSliders(); 
                }

                // 1) Sync filter form fields with the current URL params so the visible form
                //    reflects the filters that were applied on this load.
                if (filterForm) {
                    for (const el of filterForm.querySelectorAll("input[name], select[name], textarea[name]")) {
                        const name = el.name;
                        if (!name) continue;

                        const values = urlParams.getAll(name); // may be multiple for checkboxes/multi-select

                        if (values.length === 0) {
                            // No value for this field in params -> clear it
                            if (el.type === "checkbox" || el.type === "radio") {
                                el.checked = false;
                            } else {
                                el.value = "";
                            }
                        } else {
                            // There is at least one value -> set field accordingly
                            if (el.type === "checkbox") {
                                el.checked = values.includes(el.value);
                            } else if (el.type === "radio") {
                                el.checked = values.includes(el.value);
                            } else {
                                el.value = values[0];
                            }
                        }
                    }
                }

                // 2) Ensure the external sort select matches the current params
                const sortSelect = document.getElementById("sort-select");
                if (sortSelect) {
                    sortSelect.value = urlParams.get('sort') || 'newest';
                }

                // 3) If there is a Prague (praha) select that controls districts, trigger change
                //    so dependent UI (districts) updates to match current selection.
                const prahaSelect = document.getElementById("praha-selectid");
                if (prahaSelect) {
                    // Save the district value from params because the 'change' event might clear the select
                    const districtValue = urlParams.get('district');
                    
                    // Trigger change to unlock/update the district list
                    prahaSelect.dispatchEvent(new Event('change'));

                    // If a district was selected, restore it immediately
                    if (districtValue) {
                        const districtSelect = document.getElementById("districtid");
                        if (districtSelect) {
                            districtSelect.value = districtValue;
                        }
                    }
                }

                const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
                window.history.pushState({path: newUrl}, '', newUrl);
            })
            .catch(error => {
                console.error("Error loading listings:", error);
                resultsContainer.style.opacity = "1";
                resultsContainer.innerHTML = "<p>Error loading listings. Please try again.</p>";
            });
    }

    // --- 1. Submit form (SEARCH) ---
    if (filterForm) {
        filterForm.addEventListener("submit", (e) => {
            e.preventDefault();
            
            const formData = new FormData(filterForm);
            const params = new URLSearchParams();

            // Remove empty fields
            for (const [key, value] of formData) {
                if (value.trim() !== "") {
                    params.append(key, value);
                }
            }

            params.append('sort', getSortValue());
            params.set('page', 1);

            loadListings(params);
        });
    }

    // --- 2. Reset button ---
    if (resetButton && filterForm) {
        resetButton.addEventListener("click", () => {
            // A. Reset text and number inputs
            const inputs = filterForm.querySelectorAll("input");
            inputs.forEach(input => {
                if (input.type === "checkbox" || input.type === "radio") {
                    input.checked = false;
                } else {
                    input.value = "";
                }
            });

            // B. Reset selects inside the form (Praha, District)
            const selects = filterForm.querySelectorAll("select");
            selects.forEach(select => select.value = "");

            // C. Reset external sort select
            const sortSelect = document.getElementById("sort-select");
            if (sortSelect) sortSelect.value = "newest";

            // D. Important: Reset district dependency on Praha
            // (dispatch change on Praha so the district script hides them)
            const prahaSelect = document.getElementById("praha-selectid");
            if (prahaSelect) {
                prahaSelect.dispatchEvent(new Event('change'));
            }

            // E. Load clean list (no parameters)
            loadListings(new URLSearchParams());
        });
    }

    // --- 3. Live sorting ---
    document.addEventListener("change", (e) => {
        if (e.target && e.target.id === "sort-select") {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams();

            for (const [key, value] of formData) {
                if (value.trim() !== "") {
                    params.append(key, value);
                }
            }
            
            params.append('sort', e.target.value);
            params.set('page', 1);

            loadListings(params);
        }
    });
    
    // --- 4. Pagination ---
    if (resultsContainer) {
        resultsContainer.addEventListener("click", (e) => {
            if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
                e.preventDefault();
                
                const href = e.target.getAttribute('href');
                if (href) {
                    const queryString = href.split('?')[1];
                    const params = new URLSearchParams(queryString);
                    loadListings(params);
                }
            }
        });
    }
});