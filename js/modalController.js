//Composed by Xiao Yang
//To use this file to control modal in profile page

"use strict";

function closeModal(modalID, bodyID){
    document.querySelector(`#${modalID}`).style.display = "none";
    console.log("Modal closed");
    document.querySelector(`#${bodyID}`).classList.remove("fadeInDown");

    document.querySelector("body").style.overflow = "unset";
}

function launchModal(modalID, bodyID){
    document.querySelector(`#${modalID}`).style.display = "contents";
    document.querySelector(`#${bodyID}`).classList.add("fadeInDown");
    document.querySelector("body").style.overflow = "hidden";
}

document.querySelector(".full-page-cover").addEventListener("click", function(event){
    console.log("c3!");
    let modal =document.querySelector(".modal-body");
    modal.classList.add("modal-static");

});
