<?php require_once "header.php"; // instead of duplication header code ?>
<head><title>Main Page</title></head>
<body>
<h1> Main Page </h1>
<table width="100%">
  <tr>
    <td class="col1">
    <form id="regform" action="javascript:void(0);" method="post">
      <h5>Sign up</h5>
      <table width="100%">
        <tr>
          <td width="50%" style="text-align: right">
            <input type="text" required placeholder="Enter your login" id="login" form="regform" minlength="6" autofocus="autofocus"><br>
            <input type="password" required placeholder="Enter your password" id="password" form="regform" minlength="6" pattern="^.*(?=.*\d.*\d)(?=.*[a-zA-Z].*[a-zA-Z]).*$" onkeyup='checkpasswordconfirmation();'><br>
            <input type="password" required placeholder="Confirm your password" id="confirm_password" form="regform" minlength="6" pattern="^[a-zA-Z0-9]+$" onkeyup='checkpasswordconfirmation();'><br>
            <input type="email" required placeholder="Enter your email" id="email" form="regform"><br>
            <input type="text" required placeholder="Enter your full name" id="name" form="regform" minlength="2" pattern="^[a-zA-Z]+$"><br>
          </td>hint: the registration fields will be fully validated only after the button is clicked
          <td width="50%" style="text-align: left">
            <span id="loginmsg"></span><br>
            <span id="passwordmsg"></span><br>
            <span id="confirmpasswordmsg"></span><br>
            <span id="emailmsg"></span><br>
            <span id="namemsg"></span><br>
            <span id="regmsg"></span><br>
          </td>
        </tr>
      </table>
      <button type="sumbit" form="regform" class="reg" id="reg" disabled>Sign up</button>
    </form>
    </td>

    <td class="col2">
    <form id="logform" action="javascript:void(0);" method="post">
      <h5>Log in</h5>
      <table width="100%">
        <tr>
          <td width="50%" style="text-align: right">
            <input type="text" required placeholder="Enter login" id="login1" form="logform" minlength="6"><br>
            <input type="password" required placeholder="Enter password" id="password1" form="logform" minlength="6" pattern="^.*(?=.*\d.*\d)(?=.*[a-zA-Z].*[a-zA-Z]).*$"><br>
            <label><input type="checkbox" class="password-checkbox">show password</label>
          </td>
          <td width="50%" style="text-align: left">
            <span id="loginmsg1"></span><br>
            <span id="passwordmsg1"></span><br>
          </td>
        </tr>
      </table>
      <button type="submit" form="logform" class="auth" id="auth">Log in</button>
    </form>
    </td>
  </tr>
</table>
<?php require_once "footer.php"; // instead of duplication footer code ?>