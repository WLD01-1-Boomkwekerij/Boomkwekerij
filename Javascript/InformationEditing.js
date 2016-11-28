$(document).ready(function () {

    $(".ContentEditable").one("click", function () {
        SetContentEditable($(this)[0]);
    });
});

function SetContentEditable(element) {
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

    function saveTextToDatabase(text, textID) {
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "../PHP/XMLRequest.php?htmlText=" + text + "&textID=" + textID, true);
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
            }
        };
        xmlhttp.send();

    }