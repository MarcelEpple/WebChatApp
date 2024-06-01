/*
    Für /friends.php
*/

// HTMl Elemente in variablen speichern
const add_friends_button = document.getElementById("addfriend");
const flist_group = document.getElementById("flist_group");
const group = document.getElementById("flist_container");

const list_array = flist_group.querySelectorAll('li');
const search = document.getElementById('add_friends_text');

const friendlist = document.getElementById("friendlist");
const friendrequests = document.getElementById("friendrequests");

const friendsModal = document.getElementById('friendModal')

//get child elements of flist_group and make them clickable 
list_array.forEach(element => {
    element.addEventListener('mousedown', clicked_element);
});

//when user types into search bar
search.addEventListener('input', function (e) {
    console.log("input");
    //hide all list elements that do not match the input
    list_array.forEach(element => {
        if (element.innerHTML.includes(search.value)) {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    });
});

search.addEventListener('click', function (e) {
    flist_group.style.display = 'block';
});

let clicked = false;
//Wenn der Nutzer auf ein Element der Liste klickt
function clicked_element() {
    console.log("clicked");
    search.value = this.dataset.username;
    clicked = true;
    search.focus();
}

//liste ausblenden wenn search bar nicht mehr fokussiert ist
search.addEventListener('blur', function (e) {
    flist_group.style.display = 'none';
});

//wenn der nutzer das modal benutzt
friendsModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget;
    // Extract info from data-bs-* attributes
    const recipient = button.getAttribute('data-bs-username');

    // Update the modal's content.
    const modalTitle = document.getElementById('modal_name');
    const modal_reject = document.getElementById('modal_reject');
    const modal_accept = document.getElementById('modal_accept');
    
    modal_accept.setAttribute('value', recipient);
    modal_reject.setAttribute('value', recipient);
    
    modalTitle.textContent = recipient;
});


//Detect if userlist changes
let friends = [];
let friendlist_loaded = false;
//use ajax_load_friends.php to load friends and if friends change reload
function load_friends() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'ajax_load_friends.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = xhr.responseText;
            if (!friendlist_loaded) {
                friends = data;
                friendlist_loaded = true;
            } else {
                if (JSON.stringify(friends) !== JSON.stringify(data)) {
                    // reload page
                    location.reload();
                }
            }
        }
    };
    xhr.send();
}

setInterval(function () {
    load_friends();
}, 500);
