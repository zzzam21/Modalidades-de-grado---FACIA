document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const view = app.dataset.view;

    switch(view){
        case "configuration":
            const user_btn = document.getElementById("saveUser");
            user_btn.addEventListener("click", saveUser);

            const email_btn = document.getElementById("saveEmail");
            email_btn.addEventListener("click", saveEmail);

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
    console.log(document.getElementById("currentUser"));
    $('#userNameModal').modal("hide");
    Messages(data.status, data.message);

}

async function saveEmail() {
    const userEmail = document.getElementById("userEmailInputEmail").value;

    const response = await fetch(`./configuration/updateEmail`, {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(
            {email : userEmail}
        )
    });

    const data = await response.json();

    if(!response.ok){
        Messages(data.status,data.message);
        throw new Error(data.message);
    }
    
    $('#userEmailModal').modal("hide");
    Messages(data.status, data.message);

}


async function getPassword(){
    const currentPassword = document.getElementById("currentPassword");
    const newPassword = document.getElementById("NewPassword");
    const confirmPassword = document.getElementById("passwordConfirmEmail");

    const response = await fetch(`./configuration/getUser`,{
        method: 'GET',
        headers: {
            "Content-type": "application/json"
        }
    })

    data = response.json();

    if(!response){
        Messages(data.status, data.Description);
        throw new Error(data.Description);
    }

    $('#passwordModal').modal("hide");
    Messages(data.status, data.Description);
}

function Messages(status, Description) {
    Swal.fire({
        title: Description,
        icon: status,
        draggable: true
    })
};