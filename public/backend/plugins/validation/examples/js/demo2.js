var form = $('#form').formValid({
	fields: {
		"name": {
			"required": true, 
			"tests": [
				{
					"type": "null", 
					"message": "Not entered name"
				}
			]
		},
		"surname": {
			"required": true,
			"tests": [
				{
					"type": "null", 
					"message": "Not entered surname"
				}
			]
		},
		"email": {
			"required": true,
			"tests": [
				{
					"type": "null", 
					"message": "Not entered e-mail adress"
				},
				{
					"type": "email", 
					"message": "Your email is incorrect"
				}
			]
		},
		"phone": {
			"required": true,
			"tests": [
				{
					"type": "null", 
					"message": "Not entered phone number"
				},
				{
					"type": "phone", 
					"message": "Your phone number is incorrect"
				}
			]
		},
		"street": {
			"required": false,
			"tests": [
				{
					"type": "letters", 
					"message": "Your street is incorrect"
				}
			]
		},
		"homenumber": {
			"required": false,
			"tests": [
				{
					"type": "number", 
					"message": "Incorrect number"
				}
			]
		},
		"city": {
			"required": false,
			"change": function(el) {
	
				$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + el.val() + '&sensor=false', function(data) {
							 
					var postCode = "";
					
					if (data.results.length) {
					
						$.each(data.results[0].address_components, function(index, e) {
							
							if (e.types[0] == "postal_code") {
								postCode = e.short_name+"-100";
								return false;
							}

						});
					  
						$('#labelPostCode').val(postCode);
						$('label[for="labelPostCode"]').addClass('active');
					
					}
						
				});

			}
		},
		"postcode": {
			"required": false,
			"tests": [
				{
					"type": "postcode", 
					"message": "Incorrect code"
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