let checkpasswordconfirmation = function() { // password confirmation validation 
	id('regMessage').innerHTML = '';
	if (id('password').value ===
		id('confirm_password').value) {
		id('confirmpasswordMessage').style.color = 'green';
		id('confirmpasswordMessage').innerHTML = 'passwords match';
		id('reg').disabled = false;
	} else {
		id('confirmpasswordMessage').style.color = 'red';
		id('confirmpasswordMessage').innerHTML = 'passwords don\'t match';
		id('reg').disabled = true;
	} // validation of other fields is written in the html5 input tag via pattern attribute at index.php
}

let checksession = async function(naccessStatus = '') { // accessStatus is opening or closing access to db config php files before or after certain ajax requests 
	let somedata = {
		accessStatus: naccessStatus
	};
	let response = await fetch('server/getsessionstatus.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json;charset=utf-8'
		},
		body: JSON.stringify(somedata)
	});
	let result = await response.json(); // the result is a check: a session is open for any user or not
	id('username').innerHTML = result['message'];
	id('hello').hidden = (result['message'] === "no_session");
	id('unauthorized').hidden = !(result['message'] === "no_session");
	id('regform').hidden = id('unauthorized').hidden;
	id('logform').hidden = id('unauthorized').hidden;
}

function id(i) {
	return document.getElementById(i);
}

$('body').on('click', '.password-checkbox', function() { // just show password
	if ($(this).is(':checked')) {
		$('#password1').attr('type', 'text');
	} else {
		$('#password1').attr('type', 'password');
	}
});

$(document).ready(function() {
	checksession();
	$('#logout').on('click', function() {
		checksession('logout');
	})
});

$(document).ready(function() {
	$('#logform').submit(async function() {
		id('reg').disabled = true; // block the buttons until the server responds
		id('auth').disabled = true;
		id('logout').disabled = true;
		let response1 = await checksession('makingAccessToDbConfigPHPFile'); // start access for this AJAX
		let user = {
			login: $('#login1').val(),
			password: $('#password1').val()
		};
		let response = await fetch('server/login.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json;charset=utf-8'
			},
			body: JSON.stringify(user)
		});
		let result = await response.json();
		let response2 = await checksession('closingAccessToDbConfigPHPFile'); // close access for this AJAX
		id('reg').disabled = false; // user can click on the buttons one more time only after the request has returned
		id('auth').disabled = false;
		id('logout').disabled = false;

		id('loginMessage1').innerHTML = result['loginMessage'];
		id('passwordMessage1').innerHTML = result['passwordMessage'];
		id('regMessage').innerHTML = 'Registration completed!';
		checkpasswordconfirmation();
	})
});

$(document).ready(function() {
	$('#regform').submit(async function() {
		id('reg').disabled = true; // block the buttons until the server responds
		id('auth').disabled = true;
		id('logout').disabled = true;
		let response1 = await checksession('makingAccessToDbConfigPHPFile'); // start access for this AJAX
		let user = {
			login: $('#login').val(),
			password: $('#password').val(),
			email: $('#email').val(),
			name: $('#name').val()
		};
		let response = await fetch('server/registration.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json;charset=utf-8'
			},
			body: JSON.stringify(user)
		});
		let result = await response.json();
		let response2 = await checksession('closingAccessToDbConfigPHPFile'); // close access for this AJAX
		id('reg').disabled = false; // user can click on the buttons one more time only after the request has returned 
		id('auth').disabled = false;
		id('logout').disabled = false;

		id('loginMessage').innerHTML = result['loginMessage'];
		id('emailMessage').innerHTML = result['emailMessage'];
		id('regMessage').innerHTML = '';
		if (result['loginMessage'] === result['emailMessage']) // in registration.php this strings are equal only when both are empty ''
			id('regMessage').innerHTML = 'Registration completed!';
	})
});