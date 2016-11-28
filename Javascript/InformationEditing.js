function saveTextToDatabase(text, textID) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?htmlText=" + text + "&textID=" + textID, true);    
    xmlhttp.send();
}

function setContentEditable(element) {
    element.contentEditable = true;
    element.style.backgroundColor = "white";
    element.className = "";

    var saveButton = document.createElement("button");
    saveButton.innerHTML = "Save";
    saveButton.onclick = function () {
        saveTextToDatabase(element.innerHTML, parseInt(element.id.replace("textID", "")));
        window.location.reload(false);
    };

    document.body.appendChild(saveButton);
}

$(document).ready(function () {

    $(".ContentEditable").one("click", function () {
        setContentEditable($(this)[0]);
    });
});