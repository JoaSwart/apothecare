// This file defines a reusable navigation bar component for the website.
// The function creates an HTML <nav> element dynamically and returns it.
// It allows you to insert the same navbar on multiple pages without repeating code.

export function createFooter() {
    // Maak het <footer> element aan
    const footer = document.createElement('footer');
  
    // Voeg de HTML-structuur toe
    footer.innerHTML = `
      <div>
        <p class="footer-title">&copy; 2025 Apothecare</p>
        <p class="footer-p">
          Uw betrouwbare online drogisterij & apotheek voor medicijnen, vitamines, verzorging en beauty producten. 
          Snel geleverd aan huis.
        </p>
      </div>
  
      <div>
        <p class="footer-title">Voorwaarden</p>
        <a href="#" class="footer-p" style="text-decoration: none;">Producten</a>
      </div>
  
      <div>
        <p class="footer-title">020 - 123 4567</p>
        <p class="footer-p">info@apothecare.nl</p>
        <p class="footer-p">Amsterdam, Nederland</p>
      </div>
    `;
  
    // Geef het <footer> element terug zodat het elders ingevoegd kan worden
    return footer;
  }
  
  
  // THIS IS ALL AN EXAMPLE, EVERYTHING CAN BE CHANGED, I'M JUST TESTING :D