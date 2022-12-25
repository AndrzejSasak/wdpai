function openNav() {
    document.getElementById("sidenav").style.width = "50%";
    document.getElementById("sidenav").style.display = "flex";

}

function closeNav() {
    document.getElementById("sidenav").style.width = "0";
    document.getElementById("sidenav").style.display = "none";
}

function reopenNav() {
    if(window.innerWidth >= 1000) {
        document.getElementById("sidenav").style.display = "flex"
        document.getElementById("sidenav").style.width = "15%";
    }
    if(window.innerWidth < 1000) {
        document.getElementById("sidenav").style.width = "50%";
    }
}

window.onresize = reopenNav;