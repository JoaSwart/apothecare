// This file defines a reusable navigation bar component for the website.
// The function creates an HTML <nav> element dynamically and returns it.
// It allows you to insert the same navbar on multiple pages without repeating code.

export function createNavbar() {
  // Create the <nav> element
  const nav = document.createElement('nav');
  nav.classList.add('navbar'); // Add a CSS class for styling

  // Define the HTML structure of the navbar
  nav.innerHTML = `
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="products.html">Products</a></li>
      <li><a href="contact.html">Contact</a></li>
    </ul>
  `;

  // Return the completed <nav> element so it can be used elsewhere
  return nav;
}


// THIS IS ALL AN EXAMPLE, EVERYTHING CAN BE CHANGED, I'M JUST TESTING :D