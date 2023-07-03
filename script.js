function enableEdit(taskId) {
    const taskText = document.getElementById("taskText_" + taskId);
    const taskWrap = taskText.parentElement;
    const editButton = taskWrap.querySelector(".edit-button");
    const form = taskWrap.querySelector(".update-form");
    form.classList.toggle("hidden");
    editButton.classList.toggle("hidden");
}
const editButtons = document.querySelectorAll(".edit-button");
editButtons.forEach((button) => {
    button.addEventListener("click", function () {
        const taskId = this.getAttribute("data-task-id");
        enableEdit(taskId);
    });
});
