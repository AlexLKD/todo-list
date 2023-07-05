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


// ---------------------------------------------------



document.querySelectorAll('.validate-button').forEach(btn => {
    btn.addEventListener('click', e => {
        console.log(e.target.closest('.task-container').dataset.id);
        const divParent = e.target.closest('.task-container').dataset.id
        const divParent2 = e.target.closest('.task-container').dataset.ranking
        console.log(divParent2);
        // envoie un json a l'api
        changeStatus(divParent,divParent2)
            // après e retour de l'api on fait
            .then(apiResponse => {
                if (!apiResponse.result) {
                    console.error('Problème avec la requête.');
                    return;
                }
                console.log(apiResponse);
                validateTask(apiResponse.idTask);
            });
    });
});

function changeStatus(idTask, ranking, status) {
    const data = {
        action: 'validate',
        idTask: idTask,
        status: status,
        token: getCsrfToken(),
        ranking : ranking
    }
    return callAPI('PUT', data);
}
  
function validateTask(idTask) {
    document.querySelector('[data-id="' + idTask + '"]').remove();
}




async function callAPI(method, data) {
    try {
        const response = await fetch("api.php", {
            method: method,
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });
        return response.json();
    }
    catch (error) {
        console.error("Unable to load datas from the server : " + error);
    }
}



function getCsrfToken() {
    return document.querySelector('#token-csrf').value;
}
