
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
            break;
        case "Info":
            backgroundDiv.style.backgroundColor = "#90AFC5";
            titleDiv.style.backgroundColor = "#336B87";
            titleText.style.color = "#E1EDD8";
            titleText.innerHTML = "Info";
            break;
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
    var fullMessage = message;
    var regex1 = /(?=<b>)(.*?)(?=<\/b>)/g;
    var str1 = message.match(regex1);

    for (var i = 0; i < str1.length; i++)
    {
        fullMessage = fullMessage.replace(str1[i].toString(), "");
    }

    var strWhereArray = str1[1].split('\\');

    var whereError = createElement("p");
    whereError.innerHTML = "<b>Location:</b><br>" + strWhereArray[strWhereArray.length - 2] + "/" + strWhereArray[strWhereArray.length - 1];
    innerDiv.appendChild(whereError);

    var lineError = createElement("p");
    lineError.id = "lineError";
    lineError.innerHTML = "<b>line: </b>" + str1[2];
    innerDiv.appendChild(lineError);


    fullMessage = fullMessage.replace(new RegExp("<br />", "g"), "");
    fullMessage = fullMessage.replace(new RegExp("</b>", "g"), "");

    var regex2 = /(:.*\.)/g;
    str2 = fullMessage.match(regex2);
    fullMessage = str2[0].replace(": ", "");

    var whatError = createElement("p");
    whatError.innerHTML = "<b>Error:</b><br>" + fullMessage;
    innerDiv.appendChild(whatError);

}

function createPopupInfo(type, varArray)
{
    var innerDiv = createBaseWindow("Info");
    
    var whatInfo = createElement("p");
    innerDiv.appendChild(whatInfo);
    
    var whatText = createElement("p"); 
    
    if(type === "FilesBig")
    {
        whatInfo.innerHTML = "Foto's die te groot zijn:";
        
        var extraInfo = createElement("p");
        extraInfo.id = "popupExtraInfo";
        extraInfo.innerHTML = "Maximum: " + ((varArray[0] / 1024) / 1024).toFixed(2) + " mb";
        innerDiv.appendChild(extraInfo);
        
        var str1 = "<ul>";
        for(var i = 1; i < varArray.length; i++)
        {
            str1 = str1 + "<li>" + varArray[i] +"</li>";
        }
        str1 += "</ul>";
        
        whatText.innerHTML = str1;
    }
    
    innerDiv.appendChild(whatText);
    
}

$(document).ready(function ()
{
    $(".PopupWindow").click(function ()
    {
        $(getElementById("popupBackgroundDiv")).animate({top: "-320px"});
    });
});
