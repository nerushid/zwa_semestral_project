const prahaSelect = document.getElementById('praha-selectid');
const districtSelect = document.getElementById('districtid');
const districtOptgroups = Array.from(districtSelect.querySelectorAll('optgroup'))
districtSelect.innerHTML = `<option value="">Any District</option>`


prahaSelect.addEventListener('change', function(e) {
    const prahaValue = e.target.value

    districtSelect.innerHTML = `<option value="">Any District</option>`
    districtSelect.disabled = true

    if (prahaValue != "") {
        const targetGroup = districtOptgroups.find(group => group.label === prahaValue)
        const allOptions = targetGroup.querySelectorAll('option')
        if (targetGroup) {
            allOptions.forEach(function(option) {
                districtSelect.appendChild(option.cloneNode(true))
            })
            districtSelect.disabled = false
        }
    }
})