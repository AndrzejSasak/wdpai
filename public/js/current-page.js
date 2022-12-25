let docname = location.href.split("/").pop().split("?").shift();
console.log(docname);

function restyle(link) {
    link.style.backgroundImage
        = "linear-gradient(180deg, #00C9A7 0%, #1A6A5D 100%)";
    link.style.boxShadow = "0px 4px 4px rgba(0, 0, 0, 0.25)";
}

if(docname === "wardrobe") {
    const link = document.getElementById("wardrobeLink");
    restyle(link);
} else if (docname === "randomizer") {
    const link = document.getElementById("randomizerLink")
    restyle(link);
} else if (docname === "picker") {
    const link = document.getElementById("pickerLink")
    restyle(link);
} else if(docname === "outfits") {
    const link = document.getElementById("outfitsLink")
    restyle(link);
} else if(docname === "favourites") {
    const link = document.getElementById("favouritesLink")
    restyle(link);
}


