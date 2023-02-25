$(document).ready(function () {
	var toLangSelect = document.getElementById("toLang");
	var fromLangSelect = document.getElementById("fromLang");
	toLangSelect.removeChild(toLangSelect.options[0]);

	document.getElementById("fromLang").addEventListener('change',() => {
		toLangSelect.innerHTML = fromLangSelect.innerHTML;
		toLangSelect.removeChild(toLangSelect.options[fromLangSelect.value-1]);
	});
});

function isOrderFilled() {
	return document.getElementById("fileInput").value != "";
}
