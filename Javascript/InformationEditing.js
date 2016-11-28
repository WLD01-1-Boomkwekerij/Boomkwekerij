window.onload = function () {
    var elements = document.getElementsByClassName("ContentEditable");

    for (var i = 0; i < elements.length; i++) {

        var element = elements[i];

        elements[i].onclick = function () {
            SetContentEditable(element);
        };

    }
};

function SetContentEditable(element) {
    element.contentEditable = true;
    element.style.backgroundColor = "white";
    element.className = "";

    var saveButton = document.createElement("button");
    saveButton.innerHTML = "Save";
    saveButton.onclick = function () {
        saveTextToDatabase(element.innerHTML, parseInt(element.id.replace("textID", "")));
    };
    document.body.appendChild(saveButton);
}

function saveTextToDatabase(text, textID) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?htmlText=" + text + "&textID=" + textID, true);
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
        }
    };
    xmlhttp.send();

}