// Temporisation pour masquer le message après 3 secondes
setTimeout(function () {
    let messageElement = document.getElementById("message");
    messageElement.style.display = "none";
}, 3000);

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
}
