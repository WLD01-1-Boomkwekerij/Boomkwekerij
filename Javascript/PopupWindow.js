
var masterNotification;
var popupFileProgress = null;

function createBaseWindow(messageType)
{
    var backgroundDiv = createElement("div");
    backgroundDiv.id = "popupBackgroundDiv";
    $(backgroundDiv).addClass("PopupWindow");
    masterNotification.appendChild(backgroundDiv);

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
            titleDiv.style.backgroundColor = "#D64531";
            backgroundDiv.style.backgroundColor = "#E94B35";            
            titleText.style.color = "#E1EDD8";
            titleText.innerHTML = "Error";
            break;
        case "Info":
            titleDiv.style.backgroundColor = "#336B87";
            backgroundDiv.style.backgroundColor = "#90AFC5";            
            titleText.style.color = "#E1EDD8";
            titleText.innerHTML = "Info";
            break;
        case "Progress":
            titleDiv.style.backgroundColor = "#6EB5C0";
            backgroundDiv.style.backgroundColor = "#E2E8E4";            
            titleText.style.color = "#E1EDD8";
            titleText.innerHTML = "Foto Upload";
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
    $(whereError).addClass("PopupWindow");
    whereError.innerHTML = "<b>Location:</b><br>" + strWhereArray[strWhereArray.length - 2] + "/" + strWhereArray[strWhereArray.length - 1];
    innerDiv.appendChild(whereError);

    var lineError = createElement("p");
    $(lineError).addClass("PopupWindow");
    lineError.id = "lineError";
    lineError.innerHTML = "<b>line: </b>" + str1[2];
    innerDiv.appendChild(lineError);


    fullMessage = fullMessage.replace(new RegExp("<br />", "g"), "");
    fullMessage = fullMessage.replace(new RegExp("</b>", "g"), "");

    var regex2 = /(:.*\.)/g;
    str2 = fullMessage.match(regex2);
    fullMessage = str2[0].replace(": ", "");

    var whatError = createElement("p");
    $(whatError).addClass("PopupWindow");
    whatError.innerHTML = "<b>Error:</b><br>" + fullMessage;
    innerDiv.appendChild(whatError);

}

function createPopupFilesWarning(varArray)
{
    var innerDiv = createBaseWindow("Info");

    var whatInfo = createElement("p");
    $(whatInfo).addClass("PopupWindow");
    whatInfo.innerHTML = "Foto's die te groot zijn:";
    innerDiv.appendChild(whatInfo);

    var extraInfo = createElement("p");
    $(extraInfo).addClass("PopupWindow");
    extraInfo.id = "popupExtraInfo";
    extraInfo.innerHTML = "Maximum: " + ((varArray[0] / 1024) / 1024).toFixed(2) + " mb";
    innerDiv.appendChild(extraInfo);

    var str1 = "<ul>";
    for (var i = 1; i < varArray.length; i++)
    {
        str1 = str1 + "<li>" + varArray[i] + "</li>";
    }
    str1 += "</ul>";

    var whatText = createElement("p");
    $(whatText).addClass("PopupWindow");
    whatText.innerHTML = str1;
    innerDiv.appendChild(whatText);
}

function createPopupFilesProgress()
{
    var innerDiv = createBaseWindow("Progress");
    var listItem = createElement("div");
    $(listItem).addClass("PopupWindow");
    innerDiv.appendChild(listItem);
    popupFileProgress = listItem;
}

function popupAddProgressBar(xmlHttp)
{
    var progressBarBackground = createElement("div");
    progressBarBackground.id = "progressBarBackground";
    popupFileProgress.appendChild(progressBarBackground);
    
    var progressBar = createElement("div");
    progressBar.id = "progressBar";
    progressBar.style.width = "10%";
    progressBarBackground.appendChild(progressBar);
    
    var uploadText = createElement("p");
    uploadText.id = "uploadText";
    progressBarBackground.appendChild(uploadText);
    

    xmlHttp.upload.addEventListener('progress', function (e)
    {
        progressBar.style.width = Math.ceil(e.loaded / e.total) * 100 + '%';
        uploadText.innerHTML = Math.ceil(e.loaded / e.total) * 100 + '%';
        
    }, false);
}

$(document).ready(function ()
{
    masterNotification = createElement("div");
    masterNotification.id = "masterNotification";
    document.body.appendChild(masterNotification);

    $(document).on('click', '.PopupWindow', function (event)
    {
        $("#popupBackgroundDiv").last().animate({marginTop: "-260px"}, function ()
        {
            $("#popupBackgroundDiv").last().remove(); 
        });
        event.stopPropagation();
    });
});
