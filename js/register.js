function onRegister() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var password2 = document.getElementById("password2").value;
  var firstname = document.getElementById("firstname").value;
  var lastname = document.getElementById("lastname").value;
  var email = document.getElementById("email").value;

  //console.log all

  console.log(
    username +
      "&password=" +
      password +
      "&firstname=" +
      firstname +
      "&lastname=" +
      lastname +
      "&email=" +
      email
  );

  if (!username) {
    document.getElementById("errorMSG").innerHTML = "Please enter a username";
    return;
  } else if (!password) {
    document.getElementById("errorMSG").innerHTML = "Please enter a password";
    return;
  } else if (password != password2) {
    document.getElementById("errorMSG").innerHTML = "Passwords do not match";
    return;
  }

  console.log(
    "../backend/API/V1/bRegister.php?username=" +
      username +
      "&password=" +
      password +
      "&firstname=" +
      firstname +
      "&lastname=" +
      lastname +
      "&email=" +
      email
  );

  fetchAsync(
    "../backend/API/V1/bRegister.php?username=" +
      username +
      "&password=" +
      password +
      "&firstname=" +
      firstname +
      "&lastname=" +
      lastname +
      "&email=" +
      email
  ).then((data) => {
    if (data.success) {
      window.location.href = "../frontend/index.html";
    } else {
      if (data.status == "error") {
        document.getElementById("errorMSG").innerHTML = data.error;
      } else if (data.status == "success") {
        document.getElementById("errorMSG").innerHTML = "";
        document.getElementById("successMSG").innerHTML = "success";
        window.location.href = "login.html";
      }
    }
  });
}

async function fetchAsync(url) {
  let response = await fetch(url);
  let data = await response.json();
  return data;
}
