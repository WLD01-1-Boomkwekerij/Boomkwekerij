
function doXMLHttp(GetArray)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "../PHP/XMLRequest.php?" + GetArray, true);
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (xmlhttp.responseText !== "")
            {
                console.log(xmlhttp.responseText);
            }
            else
            {
                location.reload();
            }
        }
    };
    xmlhttp.send();
}

function addPlantImage(element)
{
    var plantPositioner = createElement("div");
    plantPositioner.id = "plantPositioner";
    document.getElementById("maincontent").appendChild(plantPositioner);

    var plantDiv = createElement("div");
    plantDiv.id = "plantDiv";
    plantPositioner.appendChild(plantDiv);

    var buttonAddImage = createElement("button");
    buttonAddImage.innerHTML = "Voeg toe";
    buttonAddImage.id = "buttonAddPlant";
    buttonAddImage.addEventListener("click", function ()
    {
        var imageList = "";
        for (var i = 0; i < managerImageList.length; i++)
        {
            imageList += managerImageList[i] + "*";
        }

        doXMLHttp("addPlantImages=" + imageList + "&plantID=" + element.id);
    });
    plantDiv.appendChild(buttonAddImage);

    var addButton = createElement("button");
    addButton.innerHTML = "Voeg foto toe";
    addButton.addEventListener("click", function ()
    {
        createManager(false, plantDiv);
    });
    plantDiv.appendChild(addButton);
}

$(document).ready(function ()
{
    //Reload the photoframe
    //$('#PhotoFrame').load(document.URL + ' #PhotoFrame');

    var element1 = document.getElementsByClassName("1");
    var element2Array = document.getElementsByClassName("2");

    var changeButton = createElement("div");
    $(changeButton).addClass("fa");
    $(changeButton).addClass("fa-pencil-square-o");
    element1[0].appendChild(changeButton);

    for (var i = 0; i < element2Array.length; i++)
    {
        var changeButton = createElement("div");
        $(changeButton).addClass("fa");
        $(changeButton).addClass("changeButton");
        $(changeButton).addClass("fa-pencil-square-o");
        element2Array[i].appendChild(changeButton);
    }

});