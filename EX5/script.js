function register() {
let name = document.getElementById("name").value.trim();
let email = document.getElementById("email").value.trim();
let password = document.getElementById("password").value;

let nameRegex = /^[A-Za-z ]{3,30}$/;
let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

if (name == "" || email == "" || password == "") {
document.getElementById("message").innerText =
"Please fill all fields";
return;
}

if (!nameRegex.test(name) || !emailRegex.test(email)) {
document.getElementById("message").innerText =
"Invalid Name or Email";
return;
}

let user = {
name: name,
email: email,
password: password
};

localStorage.setItem("user", JSON.stringify(user));
alert("Registration Successful");
location.href = "login.html";
}

function login() {
let email = document.getElementById("email").value;
let password = document.getElementById("password").value;
let user = JSON.parse(localStorage.getItem("user"));

if (user == null) {
document.getElementById("message").innerText =
"Please register first";
return;
}

if (email == user.email && password == user.password) {
location.href = "exam.html";
} else {
document.getElementById("message").innerText =
"Invalid Email or Password";
}
}

function submitExam() {
let score = 0;

for (let i = 1; i <= 10; i++) {
let answer = document.querySelector(
'input[name="q' + i + '"]:checked'
);

if (answer && answer.value == "1") {
score++;
}
}

localStorage.setItem("score", score);
location.href = "result.html";
}

if (document.getElementById("score")) {
let score = localStorage.getItem("score");
let user = JSON.parse(localStorage.getItem("user"));

document.getElementById("score").innerText = score;
document.getElementById("studentName").innerText =
"Student: " + user.name;

if (score >= 8) {
document.getElementById("message").innerText =
"Excellent!";
} else if (score >= 5) {
document.getElementById("message").innerText =
"Good Job!";
} else {
document.getElementById("message").innerText =
"Need Improvement";
}
}