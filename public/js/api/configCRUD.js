document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const view = app.dataset.view;

    switch(view){
        case "configuration":
            const user_btn = document.getElementById("saveUser");
            user_btn.addEventListener("click", saveUser);

            const email_btn = document.getElementById("saveEmail");
            email_btn.addEventListener("click", saveEmail);

            const password_btn = document.getElementById("savePassword");
            password_btn.addEventListener("click", savePassword);

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
    document.getElementById("currentUser").textContent = userName;
    document.getElementById("currentUserName").textContent = userName;
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
    
    
    document.getElementById("currentUserEmail").textContent = userEmail;
    $('#userEmailModal').modal("hide");
    Messages(data.status, data.message);

}

async function savePassword() {
    
    const currentPassword = document.getElementById("currentPassword").value;
    const newPassword = document.getElementById("NewPassword").value;
    const confirmPassword = document.getElementById("passwordConfirmEmail").value;

    const response = await fetch(`./configuration/updatePassword`, {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            currentPassword: currentPassword,
            newPassword: newPassword,
            confirmPassword: confirmPassword
        })
    });

    const data = await response.json();

    if(!response.ok){
        Messages(data.status,data.message);
        throw new Error(data.message);
    }

    $('#passwordModal').modal("hide");
    Messages(data.status,data.message);
}

function Messages(status, Description) {
    Swal.fire({
        title: Description,
        icon: status,
        draggable: true
    })
};