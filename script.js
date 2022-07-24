var checkpasswordconfirmation = function() { // password confirmation validation 
  document.getElementById('regmsg').innerHTML = '';
  if (document.getElementById('password').value ===
      document.getElementById('confirm_password').value) {
      document.getElementById('confirmpasswordmsg').style.color = 'green';
      document.getElementById('confirmpasswordmsg').innerHTML = 'passwords match';
      document.getElementById('reg').disabled = false;
  } else {
      document.getElementById('confirmpasswordmsg').style.color = 'red';
      document.getElementById('confirmpasswordmsg').innerHTML = 'passwords don\'t match'; // escaping a single quote
      document.getElementById('reg').disabled = true;
  } // validation of other fields is written in the html5 input tag via pattern attribute and other attributes
}


$(document).ready(function() {
  $('#logform').submit(async function() {
      document.getElementById('reg').disabled = true; // block the buttons until the server responds
      document.getElementById('auth').disabled = true;
      document.getElementById('logout').disabled = true;
      let user = {
          login: $('#login1').val(),
          password: $('#password1').val()
      };
      let response = await fetch('login.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify(user)
      });
      document.getElementById('reg').disabled = false; // you can click on the buttons one more time only after the request has returned
      document.getElementById('auth').disabled = false;
      document.getElementById('logout').disabled = false;
      let result = await response.json();
      document.getElementById('loginmsg1').innerHTML = result['loginmsg'];
      document.getElementById('passwordmsg1').innerHTML = result['passwordmsg'];
      document.getElementById('regmsg').innerHTML = 'Registration completed!';
      checkpasswordconfirmation();
      if (result['loginmsg'] === result['passwordmsg']) // in login.php this strings are equal only when both are empty ''
          checksession();
  })
});

$(document).ready(function() {
  $('#regform').submit(async function() {
      document.getElementById('reg').disabled = true; // block the buttons until the server responds
      document.getElementById('auth').disabled = true;
      document.getElementById('logout').disabled = true;
      let user = {
          login: $('#login').val(),
          password: $('#password').val(),
          email: $('#email').val(),
          name: $('#name').val()
      };
      let response = await fetch('registration.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify(user)
      });
      document.getElementById('reg').disabled = false; // you can click on the buttons one more time only after the request has returned 
      document.getElementById('auth').disabled = false;
      document.getElementById('logout').disabled = false;
      let result = await response.json();
      document.getElementById('loginmsg').innerHTML = result['loginmsg'];
      document.getElementById('emailmsg').innerHTML = result['emailmsg'];
      document.getElementById('regmsg').innerHTML = '';
      if (result['loginmsg'] === result['emailmsg']) // in registration.php this strings are equal only when both are empty ''
          document.getElementById('regmsg').innerHTML = 'Registration completed!';
  })
});

$(document).ready(function() {
  checksession();
});
var checksession = async function() {
  let somedata = {};
  let response = await fetch('getsessionstatus.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(somedata)
  });
  let result = await response.json();
  document.getElementById('username').innerHTML = result['msg'];
  document.getElementById('hello').hidden = (result['msg'] === "no_session");
  document.getElementById('unauthorized').hidden = !(result['msg'] === "no_session");
  if (document.getElementById('regform') && document.getElementById('logform')) {
      document.getElementById('regform').hidden = document.getElementById('unauthorized').hidden;
      document.getElementById('logform').hidden = document.getElementById('unauthorized').hidden;
  }
}

$(document).ready(function() {
  $('#logout').on('click', async function() {
      let somedata = {};
      let response = await fetch('logout.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify(somedata)
      });
      let result = await response.json();
      checksession();
  })
});

$('body').on('click', '.password-checkbox', function() { // just show password
  if ($(this).is(':checked')) {
      $('#password1').attr('type', 'text');
  } else {
      $('#password1').attr('type', 'password');
  }
});

$(document).ready(function() {
  $('button').on('click', async function() {
      $.ajax({
              method: "POST",
              url: "getsessionstatus.php",
              data: {}
          })
          .done(function(msg) {
              // alert( msg ); // just for testing
          });
  })
});