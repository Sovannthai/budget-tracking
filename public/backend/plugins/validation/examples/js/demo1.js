var form = $('#form').formValid({
	fields: {
		"login": {
			"required": true, 
			"tests": [
				{
					"type": "null", 
					"message": "Not entered login"
				},
				{
					"type": "email", 
					"message": "Your email is incorrect"
				}
			]
		},
		"password": {
			"required": true,
			"tests": [
				{
					"type": "null", 
					"message": "Not entered password"
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