// Temporisation pour masquer le message après 3 secondes
// setTimeout(function () {
//     let messageElement = document.getElementById("message");
//     messageElement.style.display = "none";
// }, 3000);

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

function enableEdit(taskId) {
    const taskText = document.getElementById("taskText_" + taskId);
    const tastWrap = taskText.parentElement;
    const taskInput = tastWrap.querySelector(".task-input");
    const editButton = tastWrap.querySelector(".edit-button");
    const saveButton = tastWrap.querySelector(".update-button");

    taskText.classList.add("hidden");
    taskInput.classList.remove("hidden");
    editButton.classList.add("hidden");
    saveButton.classList.remove("hidden");
}

const editButtons = document.querySelectorAll(".edit-button");
editButtons.forEach((button) => {
    button.addEventListener("click", function () {
        const taskId = this.getAttribute("data-task-id");
        enableEdit(taskId);
    });
});
