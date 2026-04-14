function toggleIA() {
    let box = document.getElementById("ia-box");

    if (box.style.display === "none" || box.style.display === "") {
        box.style.display = "block";
    } else {
        box.style.display = "none";
    }
}

function enviarMensaje() {
    let input = document.getElementById("ia-input");
    let mensaje = input.value;

    fetch(BASE_URL + "ia/chat.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "mensaje=" + encodeURIComponent(mensaje)
    })
    .then(res => res.json())
    .then(data => {
        let chat = document.getElementById("ia-chat");
        chat.innerHTML += `<div><b>Tú:</b> ${mensaje}</div>`;
        chat.innerHTML += `<div><b>IA:</b> ${data.respuesta}</div>`;
        input.value = "";
    });
}