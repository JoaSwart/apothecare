<template>
  <div class="checkout container">
  <a class="back" href="#" @click.prevent="goBack">← Terug naar winkelmandje</a>

    <div class="checkout-grid">
      <div class="checkout-left">
        <h3>Afrekenen</h3>

        <section class="card form-card">
          <h4>Persoonlijke gegevens</h4>
          <div class="row">
            <label>Volledige naam *<input v-model="name" placeholder="Jan Jansen"/></label>
            <label>E-mailadres *<input v-model="email" placeholder="jan@voorbeeld.nl"/></label>
          </div>
          <div class="row">
            <label>Telefoonnummer *<input v-model="phone" placeholder="06 12345678"/></label>
          </div>
          <div class="row">
            <label>Adres *<input v-model="straat" placeholder="Straatnaam 123"/></label>
          </div>
          <div class="row">
            <label>Postcode *<input v-model="postcode" placeholder="1234 AB"/></label>
            <label>Plaats *<input v-model="plaats" placeholder="Amsterdam"/></label>
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

          <button class="place-btn" @click="placeOrder" :disabled="placing">✔ Bestelling plaatsen</button>
          <p class="small muted">Door te bestellen gaat u akkoord met onze algemene voorwaarden</p>
        </div>
      </aside>
    </div>
  </div>
</template>

<script>
import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'
import useCart from '../store/cart'

export default {
  name: 'CheckoutPage',
  setup() {
    const router = useRouter()
    const cart = useCart()
    const items = cart.items
    const subtotal = cart.subtotal
    const total = computed(() => subtotal.value + 4.95)

    const name = ref('')
    const email = ref('')
    const phone = ref('')
    const straat = ref('')
    const postcode = ref('')
    const plaats = ref('')
    const placing = ref(false)

    const baseUrl = 'http://localhost/Projectweek%20october/apothecare/apothecare_with-vue/api/'

    function goBack() {
      router.push('/cart')
    }

    async function placeOrder() {
      if (placing.value) return

      // Basic validation
      if (!name.value || !email.value || !phone.value || !straat.value || !postcode.value || !plaats.value) {
        alert('Vul alle verplichte velden in.');
        return;
      }

      // Ensure user is logged in (optional)
      const storedUser = JSON.parse(localStorage.getItem('user') || 'null')
      if (!storedUser || !storedUser.user_id) {
        alert('Log in of maak een account aan om een bestelling te plaatsen.');
        router.push('/login');
        return;
      }

      placing.value = true

      // Prepare items payload (simplify to essential fields)
      const payloadItems = items.map(it => ({ title: it.title, price: Number(it.price), qty: it.qty, size: it.size || '' }))

      const params = new URLSearchParams()
      params.append('action', 'add')
      params.append('klantId', storedUser.user_id)
      params.append('naam', name.value)
      params.append('contact', phone.value || email.value)
      params.append('items', JSON.stringify(payloadItems))
      params.append('status', 'In afwachting')
      params.append('betaaldBedrag', total.value.toFixed(2))
      params.append('straat', straat.value)
      params.append('postcode', postcode.value)
      params.append('plaats', plaats.value)

      try {
        const res = await fetch(baseUrl + 'orders.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: params.toString()
        })
        const data = await res.json()
        if (data.success) {
          alert('Bestelling succesvol geplaatst!')
          // clear cart
          cart.clear()
          // redirect to home or a success page
          router.push('/')
        } else {
          alert('Fout bij plaatsen bestelling: ' + (data.message || 'Onbekende fout'))
        }
      } catch (err) {
        alert('Netwerkfout: ' + err.message)
      } finally {
        placing.value = false
      }
    }

    return { items, subtotal, total, goBack, name, email, phone, straat, postcode, plaats, placeOrder, placing }
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
