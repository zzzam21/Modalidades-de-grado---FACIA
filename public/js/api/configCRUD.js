document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const view = app.dataset.view;

    switch(view){
        case "configuration":
            const button = document.getElementById("saveUser");
            button.addEventListener("click", saveUser);
            break;
        default:
            break;
    }
})

async function saveUser() {
    
    const userName = document.getElementById("userNameInputEmail").value;
    
    const response = await fetch( `./configuration/updateName`,{
        method : 'PUT',
        credentials: 'same-origin',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            name: userName
        })
    });

    const data = await response.json();

    
    if(!response.ok){
        Messages(data.status,data.message);
        throw new Error(data.message);
    }

    document.getElementById('currentUser').textContent = userName;

    $('#userNameModal').modal("hide");
    Messages(data.status, data.message);

}

function Messages(status, Description) {
    Swal.fire({
        title: Description,
        icon: status,
        draggable: true
    })
};