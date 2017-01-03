//CATALOG
function createCatalogAddition()
{
    var section = createElement("section");
    section.id = "addPlantMenu";
    getElementById("mid").appendChild(section);

    var topDiv = createElement("div");
    topDiv.id = "topDiv";
    section.appendChild(topDiv);

    var buttonAddPlant = createElement("button");
    buttonAddPlant.innerHTML = "Voeg toe";
    buttonAddPlant.id = "buttonAddPlant";
    buttonAddPlant.addEventListener("click", function ()
    {
        if (!plantAdded)
        {
            plantAdded = true;
            var one = getElementById("Name");
            var two = getElementById("groep");
            var three = getElementById("hoogte_min");
            var four = getElementById("hoogte_max");
            var five = getElementById("Bloeitijd1");
            var six = getElementById("Bloeitijd2");
            var seven = getElementById("Bloeiwijze");
            var eight = "";

            if (one.checkValidity() && one.value !== "" &&
                    two.checkValidity() &&
                    three.checkValidity() && three.value !== "" &&
                    four.checkValidity() && four.value !== "" &&
                    five.checkValidity() &&
                    six.checkValidity() &&
                    seven.checkValidity() && seven.value !== "")
            {

                for (var i = 0; i < images.length; i++)
                {
                    eight += images[i] + "*";
                }

                var requestString = "../PHP/XMLRequest.php?" +
                        "name=" + one.value +
                        "&groep=" + two.value +
                        "&hoogte_min=" + three.value +
                        "&hoogte_max=" + four.value +
                        "&bloeitijd1=" + five.value +
                        "&bloeitijd2=" + six.value +
                        "&bloeiwijze=" + seven.value +
                        "&imageUrl=" + eight;

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", requestString, true);
                xmlhttp.onreadystatechange = function ()
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        if (xmlhttp.responseText !== "")
                        {
                            console.log(xmlhttp.responseText);
                        } else
                        {
                            location.reload();
                        }
                    }
                };
                xmlhttp.send();
            }
        }
    });
    topDiv.appendChild(buttonAddPlant);

    var textAddPlant = createElement("h3");
    textAddPlant.id = "b";
    textAddPlant.innerHTML = "Plant Toevoegen";
    topDiv.appendChild(textAddPlant);

    var sectionDiv = createElement("div");
    sectionDiv.id = "catalogAddDivSide";
    section.appendChild(sectionDiv);

    var rightDiv = createElement("div");
    rightDiv.id = "elementTwo";
    sectionDiv.appendChild(rightDiv);

    var leftDiv = createElement("div");
    leftDiv.id = "elementOne";
    sectionDiv.appendChild(leftDiv);


    //Naam | Inputs
    //Naam
    var textNaam = createElement("p");
    $(textNaam).addClass("catalogAddingName");
    textNaam.innerHTML = "Naam:";
    leftDiv.appendChild(textNaam);

    var inputNaam = createElement("input");
    inputNaam.class = "catalogAddingInput";
    inputNaam.id = "Name";
    inputNaam.placeholder = "Naam";
    inputNaam.type = "text";
    rightDiv.appendChild(inputNaam);

    //Select Groep
    var textGroep = createElement("p");
    textGroep.class += "catalogAddingName";
    textGroep.innerHTML = "Prijsregel:";
    leftDiv.appendChild(textGroep);


    var selectElement = createElement("select");
    selectElement.id = "groep";
    rightDiv.appendChild(selectElement);

    var xmlhttp = new XMLHttpRequest();
   
    if(document.getElementById("category").innerHTML === ""){
        xmlhttp.open("GET", "../PHP/XMLRequest.php?CatalogSelectOptions=yes", true);
    }else{

        xmlhttp.open("GET", "../PHP/XMLRequest.php?CatalogSelectOptionsCategory="+document.getElementById("category").innerHTML, true);
    }

    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            var optionArray = xmlhttp.responseText.split("*");

            for (var i = 0; i < optionArray.length - 1; i += 2)
            {
                var option = createElement("option");
                option.value = optionArray[i + 1];
                option.innerHTML = optionArray[i];
                selectElement.appendChild(option);
            }
        }
    };
    xmlhttp.send();

    //Min hoogte
    var textMinHoogte = createElement("p");
    textMinHoogte.class += "catalogAddingName";
    textMinHoogte.innerHTML = "Min Hoogte";
    leftDiv.appendChild(textMinHoogte);

    var inputMinHoogte = createElement("input");
    inputMinHoogte.class = "catalogAddingInput";
    inputMinHoogte.id = "hoogte_min";
    inputMinHoogte.type = "number";
    inputMinHoogte.placeholder = "Hoogte (in cm)";
    rightDiv.appendChild(inputMinHoogte);

    //Max Hoogte
    var textMaxHoogte = createElement("p");
    textMaxHoogte.class += "catalogAddingName";
    textMaxHoogte.innerHTML = "Max  Hoogte";
    leftDiv.appendChild(textMaxHoogte);

    var inputMaxHoogte = createElement("input");
    inputMaxHoogte.class = "catalogAddingInput";
    inputMaxHoogte.id = "hoogte_max";
    inputMaxHoogte.placeholder = "Hoogte (in cm)";
    inputMaxHoogte.type = "number";
    rightDiv.appendChild(inputMaxHoogte);

    //Bloeitijd
    var textBloeitijd = createElement("p");
    textBloeitijd.class += "catalogAddingName";
    textBloeitijd.innerHTML = "Bloeitijd";
    leftDiv.appendChild(textBloeitijd);

    var monthArray = [
        "Januari",
        "Februari",
        "Maart",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Augustus",
        "September",
        "Oktober",
        "November",
        "December"
    ];

    var inputBloeitijd1 = createElement("select");
    inputBloeitijd1.class = "catalogAddingInput";
    inputBloeitijd1.id = "Bloeitijd1";
    rightDiv.appendChild(inputBloeitijd1);

    for (var i = 0; i < monthArray.length; i++)
    {
        var option = createElement("option");
        option.value = monthArray[i];
        option.innerHTML = monthArray[i];
        inputBloeitijd1.appendChild(option);
    }

    var inputBloeitijd2 = createElement("select");
    inputBloeitijd2.class = "catalogAddingInput";
    inputBloeitijd2.id = "Bloeitijd2";
    rightDiv.appendChild(inputBloeitijd2);


    for (var i = 0; i < monthArray.length; i++)
    {
        var option = createElement("option");
        option.value = monthArray[i];
        option.innerHTML = monthArray[i];
        inputBloeitijd2.appendChild(option);
    }

    //Bloeitijd
    var textBloeiwijze = createElement("p");
    textBloeiwijze.class += "catalogAddingName";
    textBloeiwijze.innerHTML = "Bloeiwijze";
    leftDiv.appendChild(textBloeiwijze);

    var inputBloeiwijze = createElement("input");
    inputBloeiwijze.class = "catalogAddingInput";
    inputBloeiwijze.id = "Bloeiwijze";
    inputBloeiwijze.placeholder = "Bloeiwijze";
    rightDiv.appendChild(inputBloeiwijze);

    var imageButton = createElement("Button");
    imageButton.innerHTML = "Voeg foto toe";
    imageButton.id = "imageButton";

    sectionDiv.appendChild(imageButton);
    imageButton.addEventListener("click", function ()
    {
        createManager("MultipleInput", sectionDiv);
    });
}