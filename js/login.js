function onLogin() {
  var username = document.getElementById("iUsername").value;
  var password = document.getElementById("iPassword").value;

  if (!username) {
    alert("Please enter a username");
    return;
  } else if (!password) {
    alert("Please enter a password");
    return;
  }

  fetchAsync(
    "../backend/API/V1/bLogin.php?username=" +
      username +
      "&password=" +
      password
  ).then((data) => {
    if (data.success) {
      window.location.href = "../frontend/index.html";
    } else {
      if (data.status == "error") {
        document.getElementById("errorMSG").innerHTML = data.error;
      } else if (data.status == "success") {
        document.getElementById("errorMSG").innerHTML = "";
        document.getElementById("successMSG").innerHTML = "success";
        window.location.href = "../player?session=" + data.websession;
      }
    }
  });
}

async function fetchAsync(url) {
  let response = await fetch(url);
  let data = await response.json();
  return data;
}
