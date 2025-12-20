document.addEventListener("DOMContentLoaded", () => {
    const prahaSelect = document.getElementById('praha-selectid');
    const districtSelect = document.getElementById('districtid');

    if (!prahaSelect || !districtSelect) return;

    const districtOptgroups = Array.from(districtSelect.querySelectorAll('optgroup'));
    const explicitlySelectedOption = districtSelect.querySelector('option[selected]');
    let serverSavedDistrict = "";

    if (explicitlySelectedOption) {
        serverSavedDistrict = explicitlySelectedOption.value;
    }

    const serverSavedPraha = prahaSelect.value;

    function rebuildOptions(prahaValue) {
        districtSelect.innerHTML = `<option value="" selected>-- select district --</option>`;
        districtSelect.disabled = true;

        if (prahaValue !== "") {
            const targetGroup = districtOptgroups.find(group => group.label === prahaValue);
            
            if (targetGroup) {
                const allOptions = targetGroup.querySelectorAll('option');
                allOptions.forEach(function(option) {
                    const clone = option.cloneNode(true);
                    clone.removeAttribute('selected'); 
                    districtSelect.appendChild(clone);
                });
                districtSelect.disabled = false;
            }
        }
    }

    prahaSelect.addEventListener('change', function(e) {
        rebuildOptions(e.target.value);
        districtSelect.value = "";
    });

    if (serverSavedPraha !== "") {
        rebuildOptions(serverSavedPraha);

        if (serverSavedDistrict !== "") {
            districtSelect.value = serverSavedDistrict;
        } else {
            districtSelect.value = "";
        }
    } else {
        rebuildOptions("");
        districtSelect.value = "";
    }
});