//Author @Xiao Yang

"use strict";

function removeAll(){
    removeContact();
    removeFollow();
    removeSign();
    removePosts();
    displayMSG();
}

function removeContact(){
    document.querySelector("#contactLinks").remove();
}

function removeFollow(){
    document.querySelector("#followButtons").remove();
}

function removeSign(){
    document.querySelector("#userSign").remove();
}
function removePosts(){
    if (document.querySelector("#my-posts")) document.querySelector("#my-posts").remove();
}

function displayMSG(){
    document.querySelector(".user-info").insertAdjacentHTML("afterend","<div class=\"privacy-message\"><h2>This is a private account!</h2></div>");
}
removeAll()