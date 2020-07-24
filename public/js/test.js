const contentType = "application/json;charset=utf-8";

if (!library)
   var library = {};

library.json = {
    replacer: function(match, pIndent, pKey, pVal, pEnd) {
        let key = '<span class=json-key>';
        let val = '<span class=json-value>';
        let str = '<span class=json-string>';
        let r = pIndent || '';

        if (pKey)
         r = r + key + pKey.replace(/[": ]/g, '') + '</span>: ';

        if (pVal)
         r = r + (pVal[0] == '"' ? str : val) + pVal + '</span>';

        return r + (pEnd || '');
    },

    prettyPrint: function(obj) {
        let jsonLine = /^( *)("[\w]+": )?("[^"]*"|[\w.+-]*)?([,[{])?$/mg;

        return JSON.stringify(obj, null, 3)
            .replace(/&/g, '&amp;').replace(/\\"/g, '&quot;')
            .replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(jsonLine, library.json.replacer);
        }
    };

window.onload = init();

// Init
function init() {
    updateInput();
}

// Input control
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

    if ("" === url.trim()) {
        alert("Please, enter a URL.")
        return true;
    }

    return false;
}

// Calling API
function execute() {

    if (checkValidations())
        return;

    let http = new XMLHttpRequest();
    let url = document.getElementById("url").value;
    let select = document.getElementById("method");
    let method = select.options[select.selectedIndex].value;
    let data = document.getElementById("input").value;

    switch (method) {
        case 'GET':
            get(http, url);
            break;
        case 'POST':
            post(http, url, data);
            break;
        case 'DEL':
            del(http, url);
            break;
        case 'PUT':
            put(http, url, data);
            break;
        case 'PATCH':
            patch(http, url, data);
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

function put(http, url, data) {
    http.open("PUT", url);
    http.setRequestHeader('Content-type', contentType);
    http.send(data);
}

function patch(http, url, data) {
    http.open("PATCH", url);
    http.setRequestHeader('Content-type', contentType);
    http.send(data);
}

function result(http) {
    let content = http.responseText;
    let object = JSON.parse(content);

    if (typeof object === 'object' && object !== null) {
        content = document.getElementById("output").innerHTML =
            library.json.prettyPrint(object);
    }

    document.getElementById("output").innerHTML = content;
}
