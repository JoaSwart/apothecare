import { reactive, computed } from 'vue'

const state = reactive({
  items: []
})

function parsePrice(raw) {
  if (raw == null) return 0
  if (typeof raw === 'number') return raw
  const s = String(raw).replace(/[^0-9,.]/g, '').replace(',', '.')
  const n = parseFloat(s)
  return Number.isFinite(n) ? n : 0
}

function addItem(product) {
  const price = parsePrice(product.price || product.priceText || product.prijs || product.price)
  // match by title and size
  const existing = state.items.find(i => i.title === product.title && (i.size || '') === (product.size || ''))
  if (existing) {
    existing.qty += 1
  } else {
    state.items.push({
      id: Date.now() + Math.random(),
      title: product.title,
      price,
      img: product.img || product.image || product.img || '',
      sizes: product.sizes || [],
      size: product.size || (product.sizes ? product.sizes[0] : ''),
      qty: 1
    })
  }
}

function removeItemByIndex(index) {
  if (index >= 0 && index < state.items.length) state.items.splice(index, 1)
}

function increment(index) {
  if (state.items[index]) state.items[index].qty++
}

function decrement(index) {
  if (state.items[index] && state.items[index].qty > 1) state.items[index].qty--
}

function clear() { state.items.splice(0) }

const subtotal = computed(() => state.items.reduce((s, it) => s + it.price * it.qty, 0))

export default function useCart() {
  return {
    items: state.items,
    subtotal,
    addItem,
    removeItemByIndex,
    increment,
    decrement,
    clear,
  }
}
