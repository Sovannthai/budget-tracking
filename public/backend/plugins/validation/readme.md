# formValid jQuery Plugin

## Demo & Examples

<https://mrygielski.github.io/jquery.formValid/>

## Usage

```html
<form method="post" id="form">
	<div class="row">
		<div class="col-md-12">
			<input type="text" id="labelLogin" class="form-control" data-field="login">
			<label for="labelLogin">Login (email) *</label>
			<div class="valid-message"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<input type="password" id="labelPassword" class="form-control" data-field="password">
			<label for="labelSurname">Password *</label>
			<div class="valid-message"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button class="btn btn-primary" type="submit">LOGIN</button>
		</div>
	</div>
</form>
```
Each field must have an attribute `data-field`.

Include jQuery:

```html
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
```

Include plugin's CSS and JS:

```html
<link rel="stylesheet" href="src/jquery.formValid.csss">
<script src="src/jquery.formValid.js"></script>
```

Call the plugin:

```javascript
/* Init form fields */
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

/* Validates the field after the change */
form.keypress(300);
$('button[type="submit"]').click(function() {
	// Validation test 	
	form.test();
	if (form.errors() == 0) {
		alert('Ok');
	}
	return false;
});
```

## Options

Here's a list of available settings.

```javascript
$('#form').formValid({
    fields: {
        "field_name": {
            "required": true,
            "tests": [
                {
                    "type": "null",
                    "message": "..."
                },
                ...
            ],
            "change": function() {
                ...
            }
        },
        ...
    }
});
```
Option `fields` is an array containing information about all fields. The first part of the array must have a name that matches the attribute `data-field` assigned to the field in the html code.

Field options:

Attribute | Type | Default | Description
--- | --- | --- | ---
`required`| *boolean* | `false` | Determines whether the field should be required when checking. Possible values: true, false
`tests`| *Array* | - | Specifies a list of validation tests for the field. The table must be based on the `type` and `message` parameters. `type` specifies the type of test, `message` message that should appear when the field value fails the test.
`change`| *Method* | - | It allows you to embed your own code that will be called when the field value changes.

## Methods

Name            | Return             |  Params                | Description
---                        | ---            | ---                | ---
`test`| - | - | Performs a validation test of all defined fields.
`keypress`| - | *timeout:Integer* | Carries out a validation test for the modified field after a specific `timeout` value.
`errors`| Number | - | Returns information in the form of a number if the form has validation errors.


## Tests

Name            | Description
---               | ---
`null`| Checks whether the value is empty.
`email`| Checks the correctness of the email address.
`number`| Checks whether the value is a number.
`letters`| Checks whether the value is text.
`phone`| Checks the correctness of the telephone number.
`postcode`| Checks the correctness of the postal code (Poland).

You can also use the `regex` parameter instead of the test name, so you can define your own regex. Example:

```javascript
"tests": [
	{
		"regex": "^[A-Z]+$", 
		"message": "Only upper-case letter"
	}
]
```

## Installation

You can install jquery.formValid by using [Bower](http://bower.io/).

```bash
bower install jquery.formValid
```

Or you can install it through [npm](https://www.npmjs.com/):

```
npm install --save jquery.formvalid
```

Create distribution version
```
npm install
./gulp
```

## Changelog

Version            | Date | Change
---               | --- | ---
1.0.1 |2018-04-28| Addition of own regex definitions 

## License

This plugin is available under [the MIT license](https://opensource.org/licenses/mit-license.php).