// Temporisation pour masquer le message après 3 secondes
setTimeout(function () {
    var messageElement = document.getElementById("message");
    messageElement.style.display = "none";
}, 3000);


const sortableList = document.getElementById("taskList");
    const items = sortableList.querySelectorAll(".main-nav-item");

    items.forEach(item => {
        item.addEventListener("dragstart", () => {
            setTimeout(() => item.classList.add("dragging"), 0);
        });

        item.addEventListener("dragend", () => {
            item.classList.remove("dragging");
            // updateTaskOrder();
            console.log('requete asynch => server');
        });
    });

    sortableList.addEventListener("dragover", e => {
        e.preventDefault();
        const draggingItem = document.querySelector(".dragging");
        const afterElement = getDragAfterElement(sortableList, e.clientY);
        if (afterElement == null) {
            sortableList.appendChild(draggingItem);
        } else {
            sortableList.insertBefore(draggingItem, afterElement);
        }
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll(".main-nav-item:not(.dragging)")];
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }
