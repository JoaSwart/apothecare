// This file handles the main JavaScript logic for the webpage.
// It imports the navbar component and attaches it to the <header> section of the HTML document.

import { createNavbar } from './components/navbar.js'; // Import the navbar component

// Select the <header> element where the navbar will be placed
const header = document.querySelector('header');

// Call the function to create the navbar and add it inside the header
header.appendChild(createNavbar());

// Result: the navigation bar appears automatically at the top of the page
// when the website loads, without writing HTML manually on every page.

// same with the footer (tryout lol)

import { createFooter } from './components/footer.js';

const footer = document.querySelector('footer');
footer.appendChild(createFooter());

// THIS IS ALL AN EXAMPLE, EVERYTHING CAN BE CHANGED, I'M JUST TESTING :D