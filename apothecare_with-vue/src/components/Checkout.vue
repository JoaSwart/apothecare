<template>
  <div class="checkout container">
    <a class="back" href="#" @click.prevent="$emit('back')">← Terug naar winkelmandje</a>

    <div class="checkout-grid">
      <div class="checkout-left">
        <h3>Afrekenen</h3>

        <section class="card form-card">
          <h4>Persoonlijke gegevens</h4>
          <div class="row">
            <label>Volledige naam *<input placeholder="Jan Jansen"/></label>
            <label>E-mailadres *<input placeholder="jan@voorbeeld.nl"/></label>
          </div>
          <div class="row">
            <label>Telefoonnummer *<input placeholder="06 12345678"/></label>
          </div>
          <div class="row">
            <label>Adres *<input placeholder="Straatnaam 123"/></label>
          </div>
          <div class="row">
            <label>Postcode *<input placeholder="1234 AB"/></label>
            <label>Plaats *<input placeholder="Amsterdam"/></label>
          </div>
        </section>

        <section class="card form-card">
          <h4>Betaalmethode</h4>
          <div class="payment-options">
            <div class="pay-option"> <input type="radio" name="pay" checked/> <div><strong>iDEAL</strong><div class="muted">Direct betalen via uw bank</div></div></div>
            <div class="pay-option"> <input type="radio" name="pay"/> <div><strong>Creditcard</strong><div class="muted">Visa, Mastercard, American Express</div></div></div>
            <div class="pay-option"> <input type="radio" name="pay"/> <div><strong>PayPal</strong><div class="muted">Veilig betalen met PayPal</div></div></div>
            <div class="pay-option"> <input type="radio" name="pay"/> <div><strong>Bankoverschrijving</strong><div class="muted">Achteraf betalen via overschrijving</div></div></div>
          </div>

          <label class="bank-select">Selecteer uw bank
            <select>
              <option>ING</option>
              <option>Rabobank</option>
            </select>
          </label>
        </section>
      </div>

      <aside class="checkout-right">
        <div class="summary card">
          <h4>Overzicht</h4>
          <ul class="items">
            <li v-for="it in items" :key="it.id">
              <div class="name">{{ it.title }}</div>
              <div class="price">€{{ it.price.toFixed(2) }}</div>
              <div class="qty">Aantal: {{ it.qty }}</div>
            </li>
          </ul>

          <div class="summary-row"><span>Subtotaal</span><span>€{{ subtotal.toFixed(2) }}</span></div>
          <div class="summary-row"><span>Verzendkosten</span><span>€4.95</span></div>

          <div class="summary-row total"><strong>Totaal</strong><strong>€{{ total.toFixed(2) }}</strong></div>

          <button class="place-btn">✔ Bestelling plaatsen</button>
          <p class="small muted">Door te bestellen gaat u akkoord met onze algemene voorwaarden</p>
        </div>
      </aside>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue'
import useCart from '../store/cart'

export default {
  name: 'CheckoutPage',
  setup() {
    const cart = useCart()
    const items = cart.items
    const subtotal = cart.subtotal
    const total = computed(() => subtotal.value + 4.95)
    return { items, subtotal, total }
  }
}
</script>

<style scoped>
.checkout { padding: 30px 20px }
.back { display:block; margin-bottom:12px; color:#333; text-decoration:none }
.checkout-grid { display:grid; grid-template-columns:1fr 360px; gap:24px }
.card { background:#fff; border:1px solid #eee; padding:16px; border-radius:8px }
.form-card { margin-bottom:18px }
.row { display:flex; gap:12px; margin-bottom:10px }
label { display:block; flex:1 }
input[type="text"], input[type="email"], select, input { width:100%; padding:8px; border-radius:6px; border:1px solid #f0f0f0; background:#fbfbfb }
.payment-options { display:flex; flex-direction:column; gap:10px }
.pay-option { display:flex; gap:12px; align-items:center; padding:10px; border:1px solid #f0f0f0; border-radius:6px }
.muted { color:#888; font-size:13px }
.summary .items { list-style:none; padding:0; margin:0 0 10px 0 }
.summary .items li { padding:8px 0; border-bottom:1px solid #f5f5f5 }
.summary-row { display:flex; justify-content:space-between; padding:6px 0 }
.summary-row.total { font-weight:700; margin-top:8px; border-top:1px solid #eee; padding-top:12px }
.place-btn { width:100%; background:#2f7a3a; color:#fff; padding:10px; border-radius:6px; border:none; margin-top:10px }
.small { font-size:12px }

@media (max-width:900px) { .checkout-grid { grid-template-columns:1fr } }

</style>
