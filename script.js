// Temporisation pour masquer le message après 3 secondes
// setTimeout(function () {
//     var messageElement = document.getElementById("message");
//     messageElement.style.display = "none";
// }, 3000);


const sortableList = document.getElementById("taskList");
const items = sortableList.querySelectorAll(".main-nav-item");
const URL_ACTIONS = 'actions.php';

items.forEach(item => {
    item.addEventListener("dragstart", () => {
        setTimeout(() => item.classList.add("dragging"), 0);
    });

    item.addEventListener("dragend", () => {
        item.classList.remove("dragging");
        updateTaskOrder();
        console.log('Requête asynchrone envoyée au serveur');
    });
});

function updateTaskOrder() {
    const taskIds = Array.from(items).map(item => item.dataset.taskid);

    // Create the data object with the taskIds property
    const data = {
        taskIds: taskIds
    };
    fetch(URL_ACTIONS, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json()) // Parse the response as JSON
    .then(responseData => {
        console.log(responseData); // Log the parsed JSON response
        // Handle the parsed data as needed
        if (responseData.success) {
            console.log(responseData.message);
        } else {
            console.log("Erreur : " + responseData.message);
        }
    })
    .catch(error => {
        console.log(error); // Log any errors during the AJAX request
    });}


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
