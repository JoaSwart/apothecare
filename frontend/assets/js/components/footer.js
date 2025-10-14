
// footer.js
// We maken een eigen app zodat deze los van de header kan mounten.
// (Mocht je één app willen, importeer of registreer de component dan in header.js)
const footerApp = Vue.createApp({});

footerApp.component('site-footer', {
  template: `
    <footer class="site-footer">
      <div class="footer-col">
        <p class="footer-title">&copy; 2025 Apothecare</p>
        <p class="footer-p">
          Uw betrouwbare online drogisterij & apotheek voor medicijnen, vitamines, verzorging en beauty producten.
          Snel geleverd aan huis.
        </p>
      </div>

      <div class="footer-col">
        <p class="footer-title">Voorwaarden</p>
        <a href="#" class="footer-p link-reset">Producten</a>
      </div>

      <div class="footer-col">
        <p class="footer-title">020 - 123 4567</p>
        <p class="footer-p">info@apothecare.nl</p>
        <p class="footer-p">Amsterdam, Nederland</p>
      </div>
    </footer>
  `
});

footerApp.mount('#footer-app');