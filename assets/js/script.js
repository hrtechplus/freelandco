"use strict";

/**
 * add event on element
 */

const addEventOnElement = function (element, type, listener) {
  if (element.length > 1) {
    for (let i = 0; i < element.length; i++) {
      element[i].addEventListener(type, listener);
    }
  } else {
    element.addEventListener(type, listener);
  }
};

/**
 * navbar toggle
 */

const navbar = document.querySelector("[data-navbar]");
const navLinks = document.querySelectorAll("[data-nav-link]");
const navToggler = document.querySelector("[data-nav-toggler]");

const toggleNav = function () {
  navbar.classList.toggle("active");
  this.classList.toggle("active");
};

addEventOnElement(navToggler, "click", toggleNav);

const closeNav = function () {
  navbar.classList.remove("active");
  navToggler.classList.remove("active");
};

addEventOnElement(navLinks, "click", closeNav);

/**
 * add active class on header & back to top button
 */

const header = document.querySelector("[data-header]");
const backTopBtn = document.querySelector("[data-back-top-btn]");

window.addEventListener("scroll", function () {
  if (window.scrollY >= 50) {
    header.classList.add("active");
    backTopBtn.classList.add("active");
  } else {
    header.classList.remove("active");
    backTopBtn.classList.remove("active");
  }
});

/**
 * hero tab button
 */

const tabBtns = document.querySelectorAll("[data-tab-btn]");

let lastClickedTabBtn = tabBtns[0];

const changeTab = function () {
  lastClickedTabBtn.classList.remove("active");
  this.classList.add("active");
  lastClickedTabBtn = this;
};

addEventOnElement(tabBtns, "click", changeTab);

/* 
js code to check all fields whether empty or not, if the fields are empty prompt to user to enter data into each field. the 'max-price' input filed is optional.
*/
const form = document.querySelector(".hero-form");
const emailInput = document.querySelector("#search");
const categoryInput = document.querySelector("#category");
const addressInput = document.querySelector("#Address");

form.addEventListener("submit", (event) => {
  event.preventDefault();

  if (
    emailInput.value === "" ||
    categoryInput.value === "" ||
    addressInput.value === ""
  ) {
    alert("Please enter data into each field");
  } else {
    // Submit the form
    form.submit();
  }
});
