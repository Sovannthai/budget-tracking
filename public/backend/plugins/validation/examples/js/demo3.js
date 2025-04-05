var form = $('#form').formValid({
	fields: {
		"subject": {
			"required": true, 
			"tests": [
				{
					"regex": "^[A-Z]+$", 
					"message": "Only upper-case letter"
				}
			]
		}
	}
});

form.keypress(300);

$('button[type="submit"]').click(function() {
	form.test();
	if (form.errors() == 0) {
		alert('Ok');
	}
	return false;
});