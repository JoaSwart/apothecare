<template>
  <div class="cart-page container">
    <div class="cart-grid">
      <div class="cart-items">
        <div v-if="items.length === 0" class="empty-cart">
          Je winkelmandje is leeg. Voeg producten toe op de productpagina.
        </div>
        <div class="cart-item" v-for="(item, index) in items" :key="item.id">
          <img class="item-image" :src="item.image" alt="product" />
          <div class="item-body">
            <h3 class="item-title">{{ item.title }}</h3>
            <div class="item-price">${{ item.price.toFixed(2) }}</div>

            <div class="item-controls">
              <label class="size-label">Size: 
                <select v-model="item.size" class="size-select">
                  <option v-for="s in item.sizes" :key="s" :value="s">{{ s }}</option>
                </select>
              </label>

              <div class="qty-controls">
                <button class="qty-btn" @click="decrement(index)">−</button>
                <div class="qty">{{ item.qty }}</div>
                <button class="qty-btn" @click="increment(index)">+</button>
                <button class="delete-btn" @click="remove(index)"><i class="fa fa-trash"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <aside class="cart-summary">
        <div class="summary-card">
          <h4>Cart Summary</h4>
          <div class="summary-row">
            <span>Subtotal</span>
            <span class="muted">________________________</span>
          </div>
          <div class="summary-row">
            <span>Shipping</span>
            <span>$5.00</span>
          </div>
          <div class="summary-row">
            <span>Estimated tax</span>
            <span>$5.00</span>
          </div>

          <div class="summary-row total">
            <span>Total</span>
            <span>${{ total.toFixed(2) }}</span>
          </div>

          <button class="checkout-btn" @click="onCheckout">Checkout</button>
          <div class="payment-muted">PayPal, Credit Card</div>

          <div class="promo">
            <label>Promo Code</label>
            <div class="promo-row">
              <input v-model="promo" placeholder="Enter promo code" />
              <button class="apply-btn" @click="applyPromo">Apply</button>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue'
import useCart from '../store/cart'

export default {
  name: 'CartPage',
  setup(_, { emit }) {
    const cart = useCart()
    const items = cart.items
    const subtotal = cart.subtotal
    const shipping = 5.0
    const tax = 5.0
    const total = computed(() => subtotal.value + shipping + tax)
    const promo = ref('')

    function increment(i) { cart.increment(i) }
    function decrement(i) { cart.decrement(i) }
    function remove(i) { cart.removeItemByIndex(i) }
    function applyPromo() { alert(`Promo '${promo.value}' applied (demo)`) }

    function onCheckout() {
      // notify parent (App.vue) to show checkout page
      emit('checkout')
    }

    return {
      items,
      promo,
      subtotal,
      shipping,
      tax,
      total,
      increment,
      decrement,
      remove,
      applyPromo,
      onCheckout,
    }
  },
}
</script>

<style scoped>
.cart-page {
  padding: 40px 30px;
  font-family: 'Inter', Arial, sans-serif;
}
.cart-grid {
  display: grid;
  grid-template-columns: 1fr 360px;
  gap: 30px;
  align-items: start;
}
.cart-items {
  background: #fff;
}
.cart-item {
  display: flex;
  gap: 20px;
  padding: 18px 0;
  border-bottom: 1px solid #eee;
  align-items: center;
}
.item-image {
  width: 96px;
  height: 96px;
  object-fit: cover;
  border-radius: 4px;
}
.item-title {
  margin: 0 0 6px 0;
  font-size: 16px;
}
.item-price {
  color: #333;
  margin-bottom: 10px;
}
.item-controls {
  display: flex;
  align-items: center;
  gap: 18px;
}
.size-label {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #f7f7f7;
  padding: 6px 10px;
  border-radius: 6px;
  font-size: 13px;
  color: #555;
}
.size-select {
  border: none;
  background: transparent;
}
.qty-controls {
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.qty-btn {
  width: 32px;
  height: 32px;
  border: 1px solid #e6e6e6;
  background: #fff;
  border-radius: 4px;
  cursor: pointer;
}
.qty { width: 28px; text-align:center }
.delete-btn { background:transparent; border:none; color:#666; margin-left:6px; cursor:pointer }

.cart-summary .summary-card {
  border: 2px solid #000;
  padding: 18px;
  border-radius: 8px;
}
.summary-card h4 { margin:0 0 12px 0 }
.summary-row { display:flex; justify-content:space-between; padding:8px 0; color:#333 }
.summary-row.total { border-top:1px solid #eee; font-weight:600; padding-top:14px }
.checkout-btn { width:100%; background:#111; color:#fff; padding:12px 14px; border-radius:6px; border:none; margin-top:14px; cursor:pointer }
.payment-muted { text-align:center; color:#999; padding:10px 0 }
.promo { margin-top:12px }
.promo-row { display:flex; gap:8px }
.promo-row input { flex:1; padding:8px 10px; border-radius:6px; border:1px solid #f0f0f0; background:#f7f7f9 }
.apply-btn { background:#111; color:#fff; border:none; padding:8px 12px; border-radius:6px; cursor:pointer }

@media (max-width: 900px) {
  .cart-grid { grid-template-columns: 1fr }
  .cart-summary { order: 2 }
}

</style>
