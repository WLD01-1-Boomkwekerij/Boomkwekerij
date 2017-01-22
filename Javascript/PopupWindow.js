
function createBaseWindow(messageType)
{
    var backgroundDiv = createElement("div");
    backgroundDiv.id = "popupBackgroundDiv";
    $(backgroundDiv).addClass("PopupWindow");
    document.body.appendChild(backgroundDiv);

    var titleDiv = createElement("div");
    titleDiv.id = "popupTitleDiv";
    $(titleDiv).addClass("PopupWindow");
    backgroundDiv.appendChild(titleDiv);

    var titleText = createElement("p");
    titleText.id = "popupTitleText";
    $(titleText).addClass("PopupWindow");
    titleDiv.appendChild(titleText);

    switch (messageType)
    {
        case "Error":
            backgroundDiv.style.backgroundColor = "#E94B35";
            titleDiv.style.backgroundColor = "#D64531";
            titleText.style.color = "#E1EDD8";
            titleText.innerHTML = "Error";
    }

    var innerDiv = createElement("div");
    innerDiv.id = "popupInnerDiv";
    $(innerDiv).addClass("PopupWindow");
    backgroundDiv.appendChild(innerDiv);

    return innerDiv;
}

function createPopupError(message)
{
    var innerDiv = createBaseWindow("Error");

    var errorMessage = createElement("p");
    errorMessage.id = "popupMessage";
    $(errorMessage).addClass("PopupWindow");
    errorMessage.innerHTML = message;
    innerDiv.appendChild(errorMessage);

}

$(document).ready(function ()
{
    $(".PopupWindow").click(function ()
    {
        $(".PopupWindow").animate({top: "-320px"});

    });
});
