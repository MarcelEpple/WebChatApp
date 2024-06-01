let chatpartner = document.getElementById("chat_partner").innerText;
let chat_container = document.getElementById("chat_container");

//Interne Variablen
let recentmessage = [];

requestmessages();
setInterval(requestmessages, 1000);

//Nachrichten empfangen
function requestmessages() {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let data = JSON.parse(xmlhttp.responseText);
            
            //nur aktualiisieren wenn neue nachrichten da sind 
            if (JSON.stringify(recentmessage) !== JSON.stringify(data)) {
                console.log("new messages");
                recentmessage = data;
                
                // Chat leeren
                chat_container.innerHTML = "";
                //loop durch data
                data.forEach(function(message) {
                    let date = new Date(message.time);
                    let dateString = date.toLocaleDateString();
                    dateString += " " + date.toLocaleTimeString();
                    dateString = dateString.substring(0, dateString.length - 3);
                    
                    insertnewMessage(message.from, message.msg, dateString);
                });
            }
        }
    };

    xmlhttp.open("GET", "ajax_load_messages.php?to=" + chatpartner, true);
    xmlhttp.send();
}


function scrollToBottom() {
    var chatContainer = document.getElementById('chat_container');
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

function insertnewMessage(user, text, date) {
    // Message Elemente erstellen
    let message = document.createElement("p");
    message.classList.add("text-start");

    if(user!=chatpartner){
        message.innerHTML = user + ": " + text;
        let time = document.createElement("span");
        time.classList.add("float-end");
        time.innerHTML = date;
        message.appendChild(time);
        chat_container.appendChild(message);
        
        scrollToBottom();
    }
    else{   
    console.log("loading"); }
}

//Nachricht versenden:
function sendmessage(text, user) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
            console.log("Send Message...");
            //gesendete nachrichten sollten direkt angezeigt werden
            let date = new Date();
            insertnewMessage(user, text, date.toLocaleTimeString());
        }
    };
    xmlhttp.open("POST", "ajax_send_message.php", true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    // Daten für die Anfrage erstellen (Nachricht und Empfänger)
    let data = {
        msg: text,
        to: user
    };
    let jsonString = JSON.stringify(data); // Als JSON serialisieren
    xmlhttp.send(jsonString); // Anfrage senden
}


let sendMessageButton = document.getElementById("sendMessage");
sendMessageButton.addEventListener("click", function () {
    // Wenn der Senden-Button geklickt wird, rufe die sendmessage-Funktion auf
    let messageInput = document.getElementById("text");
    let messageText = messageInput.value.trim(); 

    console.log("Message: " + messageText);
    console.log("Chatpartner: " + chatpartner);
    if (messageText !== "") {
        // Nur Nachrichten senden, wenn der Text nicht leer ist
        sendmessage(messageText, chatpartner);

        // Hier kannst du weitere Aktionen ausführen, z. B. das Eingabefeld leeren
        messageInput.value = "";
    } else {
        // Optional: Benutzer informieren, dass leere Nachrichten nicht gesendet werden können
        console.log("Cannot send an empty message.");
    }
});


let messageInput = document.getElementById("text");
messageInput.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        sendMessageButton.click();
    }
});

function openModal() {
    let friend = document.getElementById("chat_partner").innerText;
           
          const myModal = new bootstrap.Modal(document.getElementById('chatModal'));
          
          document.getElementById("chatModalHeader").innerText = "Remove " + friend + " as friend?"
          document.getElementById("chatModalBody").innerText = " Do you really want to end your friendship with " + friend + "?"


          myModal.show()
      }
