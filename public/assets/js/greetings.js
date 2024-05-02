let now = new Date();

let currentHour = now.getHours();

let greeting;
if (currentHour >= 5 && currentHour < 12) {
    greeting = 'Good morning, ';
} else if (currentHour >= 12 && currentHour < 18) {
    greeting = 'Good afternoon, ';
} else {
    greeting = 'Good evening, ';
}

window.onload = function () {
    let element = document.getElementById('greeting');
    element.innerHTML = greeting + element.innerHTML;
};