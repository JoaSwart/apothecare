<template>
  <footer class="site-footer">
    <div class="footer-col">
      <p class="footer-title">&copy; 2025 Apothecare</p>
      <p class="footer-p">
        Uw betrouwbare online drogisterij & apotheek voor medicijnen, vitamines,
        verzorging en beauty producten. Snel geleverd aan huis.
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
</template>

<script>
export default {
  name: "SiteFooter",
};
</script>

<style scoped>
footer {
  background-color: #ffffff;
  display: flex;
  color: #000000;
  text-align: left;
  padding: 20px 0;
  position: relative;
  flex-wrap: wrap;
  justify-content: space-between;
  border-top: 1px solid #e0e0e0;
  font-family: Arial, sans-serif;
  width: 100%; /* use container width to avoid horizontal scroll */
  box-sizing: border-box;
}

footer div {
  flex: 1 1 220px; /* responsive columns */
  max-width: 33%;
  padding: 0 20px;
  box-sizing: border-box;
}

.footer-title {
  font-size: 18px;
  margin-bottom: 15px;
  color: black;
  padding: 5px;
}

.footer-p {
  font-size: 16px;
  color: #52555e;
  padding: 5px;
}
</style>
