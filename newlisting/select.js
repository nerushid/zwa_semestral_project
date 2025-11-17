document.addEventListener("DOMContentLoaded", () => {
	const praSelect = document.getElementById("praha-selectid")
	const districtSelect = document.getElementById("districtid")
	if (!praSelect || !districtSelect) return

	const groups = {}
	Array.from(districtSelect.querySelectorAll("optgroup")).forEach(og => {
		const label = (og.label || "").trim()
		groups[label] = Array.from(og.querySelectorAll("option")).map(opt => opt.outerHTML)
	})

	const placeholder = '<option value="">-- select district --</option>'

	districtSelect.innerHTML = placeholder
	districtSelect.disabled = true

	praSelect.addEventListener("change", function () {
		const sel = (this.value || "").trim()
		if (!sel || !groups[sel]) {
			districtSelect.innerHTML = placeholder
			districtSelect.disabled = true
			return
		}

		districtSelect.innerHTML = placeholder + groups[sel].join("")
		districtSelect.disabled = false

		if (districtSelect.options.length > 1) districtSelect.selectedIndex = 1
		districtSelect.focus()
	})
})
