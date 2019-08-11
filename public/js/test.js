const contentType = "application/json;charset=utf-8";

window.onload = init();

//INIT
function init() {
    updateInput();
}



//CONTROL INPUT
function updateInput() {
    let select = document.getElementById("method");
    let method = select.options[select.selectedIndex].value;

    if (method === 'GET' || method === 'DEL')
        document.getElementById("input").setAttribute("disabled", true);
    else
        document.getElementById("input").removeAttribute("disabled");
}

function checkValidations() {
    let url = document.getElementById("url").value;

    if  ("" === url.trim()) {
        alert("Please, enter a url.")
        return true;
    }
       
    return false;
}


//CALL API
function execute() {

    if (checkValidations()) return;

    let http = new XMLHttpRequest();
    let url = document.getElementById("url").value;
    let select = document.getElementById("method");
    let method = select.options[select.selectedIndex].value;
    let data = document.getElementById("input").value;


    switch(method) {
        case 'GET':
            get(http, url);
            break;
        case 'POST': 
            post(http, url, data);   
            break;
        case 'DEL':
            del(http, url);
            break;
        default:
            alert('Please, select a method type.');
    }

    http.onreadystatechange = (e) => {
        result(http);
    }
}

function post(http, url, data) {
    
    http.open("POST", url);
    http.setRequestHeader('Content-type', contentType);
    http.send(data);
}

function get(http, url) {

    http.open("GET", url);
    http.setRequestHeader('Content-type', contentType);
    http.send();
}

function del(http, url) {

    http.open("DELETE", url);
    http.setRequestHeader('Content-type', contentType);
    http.send();
}

function result(http) {
    document.getElementById("output").value = http.responseText;
}

