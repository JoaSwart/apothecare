<template>
  <div class="page-bg">
    <main class="container">
      <h2 class="page-title">Webshop Dashboard</h2>

      <!-- Add logout button here (quick placement) -->
      <button @click="handleLogout" style="margin: 10px; padding: 8px; background: red; color: white; border: none; border-radius: 4px; cursor: pointer;">Uitloggen</button>

      <section class="metrics">
        <div class="stat-card">
          <div class="stat-icon">↗</div>
          <div class="stat-body">
            <div class="stat-label">Omzet</div>
            <div class="stat-value">{{ omzet }}</div>
            <div class="stat-sub">Per maand</div>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon">🧾</div>
          <div class="stat-body">
            <div class="stat-label">Totaal bestellingen</div>
            <div class="stat-value">{{ totalOrders }}</div>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon">📦</div>
          <div class="stat-body">
            <div class="stat-label">Producten</div>
            <div class="stat-value">{{ products }}</div>
          </div>
        </div>
      </section>

      <nav class="segmented">
        <button :class="['seg-btn', active === 'bestellingen' ? 'active' : '']" @click="active='bestellingen'">Bestellingen</button>
        <button :class="['seg-btn', active === 'producten' ? 'active' : '']" @click="setActiveAndFetch('producten')">Producten</button>
        <button :class="['seg-btn', active === 'klanten' ? 'active' : '']" @click="active='klanten'">Klanten</button>
        <input 
          type="text" 
          placeholder="Zoek op naam of categorie..." 
          class="search-input" 
          v-model="searchQuery"
          @input="filterProducts"
          @keyup.enter="filterProducts"
        />
      </nav>

      <!-- Bestellingen section -->
      <section class="panel" v-if="active === 'bestellingen'">
        <h3 class="panel-title">Bestellingen Overzicht</h3>

        <div class="table-wrap">
          <table class="orders-table">
            <thead>
              <tr>
                <th>Klant ID</th>
                <th>Naam</th>
                <th>Contact</th>
                <th>Items</th>
                <th>Datum</th>
                <th>Status</th>
                <th>Acties</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orders" :key="order.id">
                <td>{{ '#' + order.id }}</td>
                <td>{{ order.name }}</td>
                <td>{{ order.contact }}</td>
                <td class="center">{{ order.items }}</td>
                <td>{{ order.date }}</td>
                <td><span :class="['badge', order.statusClass]">{{ order.status }}</span></td>
                <td><a href="#" @click.prevent="view(order)">Bekijken</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Producten section -->
      <section class="panel" v-if="active === 'producten'">
        <h3 class="panel-title">Producten Overzicht</h3>

        <!-- Add product button -->
        <button @click="openAddModal" class="btn-add">+ Product toevoegen</button>

        <!-- Loading indicator -->
        <p v-if="loadingProducts">Laden producten...</p>

        <div class="table-wrap" v-if="!loadingProducts">
          <table class="orders-table">
            <thead>
              <tr>
                <th>Naam</th>
                <th>Categorie</th>
                <th>Prijs</th>
                <th>Gram</th>
                <th>Afbeelding</th>
                <th>Acties</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in filteredProducts" :key="product.product_id">
                <td>{{ product.name }}</td>
                <td>{{ product.category }}</td>
                <td>€{{ Number(product.price).toFixed(2) }}</td>
                <td>{{ product.grams }}g</td>
                <td>
                  <img :src="product.image_url" alt="Product afbeelding" style="width: 50px; height: auto;" />
                </td>
                <td>
                  <a href="#" @click.prevent="openEditModal(product)">Bewerken</a> |
                  <a href="#" @click.prevent="deleteProduct(product)">Verwijderen</a>
                </td>
              </tr>
              <tr v-if="filteredProducts.length === 0">
                <td colspan="6">
                  {{ searchQuery ? 'Geen producten gevonden voor "' + searchQuery + '"' : 'Geen producten gevonden in de database.' }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Klanten section -->
      <section class="panel" v-if="active === 'klanten'">
        <h3 class="panel-title">Klanten Overzicht</h3>

        <div class="table-wrap">
          <table class="orders-table">
            <thead>
              <tr>
                <th>Klant ID</th>
                <th>Naam</th>
                <th>E-mail</th>
                <th>Telefoon</th>
                <th>Registratiedatum</th>
                <th>Bestellingen</th>
                <th>Acties</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="klant in klantenList" :key="klant.id">
                <td>{{ '#' + klant.id }}</td>
                <td>{{ klant.naam }}</td>
                <td>{{ klant.email }}</td>
                <td>{{ klant.telefoon || 'N/A' }}</td>
                <td>{{ klant.registratiedatum }}</td>
                <td class="center">{{ klant.bestellingen }}</td>
                <td>
                  <a href="#" @click.prevent="editKlant(klant)">Bewerken</a> |
                  <a href="#" @click.prevent="deleteKlant(klant)">Verwijderen</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Modal for Add/Edit Product -->
      <div v-if="showModal" class="modal-overlay" @click="closeModal">
        <div class="modal-content" @click.stop>
          <h3>{{ isEditMode ? 'Product Bewerken' : 'Nieuw Product Toevoegen' }}</h3>
          <form @submit.prevent="saveProduct">
            <label>Naam:</label>
            <input v-model="modalForm.name" required />

            <label>Categorie:</label>
            <input v-model="modalForm.category" required />

            <label>Prijs (€):</label>
            <input type="number" step="0.01" v-model.number="modalForm.price" required />

            <label>Gram (g):</label>
            <input type="number" v-model.number="modalForm.grams" required />

            <label>Afbeelding URL:</label>
            <input v-model="modalForm.image_url" required />

            <div class="modal-actions">
              <button type="submit">{{ isEditMode ? 'Bijwerken' : 'Toevoegen' }}</button>
              <button type="button" @click="closeModal">Annuleren</button>
            </div>
          </form>
        </div>
      </div>

    </main>
  </div>
</template>

<script>
import { ref, computed } from 'vue'; // Add computed for filteredProducts

export default {
  name: 'DashBoard',
  setup() {
    const omzet = ref(930);
    const totalOrders = ref(0);
    const products = ref(0);
    const active = ref('bestellingen');
    const loadingProducts = ref(false);
    const searchQuery = ref(''); 

    const orders = ref([
      { id:1, name:'Jan de Vries', contact:'jan@email.com', items:3, date:'14 okt 2025', status:'Voltooid', statusClass:'voltooid' },
      { id:2, name:'Maria Bakker', contact:'maria@email.com', items:1, date:'13 okt 2025', status:'In behandeling', statusClass:'inbehandeling' },
      { id:3, name:'Piet Jansen', contact:'piet@email.com', items:5, date:'12 okt 2025', status:'In afwachting', statusClass:'inafwachting' },
    ]);

    const productsList = ref([]);

    const klantenList = ref([
      { id: 1, naam: 'Jan de Vries', email: 'jan@email.com', telefoon: '06-12345678', registratiedatum: '12 okt 2025', bestellingen: 3 },
      { id: 2, naam: 'Maria Bakker', email: 'maria@email.com', telefoon: '06-87654321', registratiedatum: '10 okt 2025', bestellingen: 1 },
      { id: 3, naam: 'Piet Jansen', email: 'piet@email.com', telefoon: '', registratiedatum: '08 okt 2025', bestellingen: 5 },
    ]);

    totalOrders.value = orders.value.length;

    const baseUrl = 'http://localhost/Projectweek%20october/apothecare/apothecare_with-vue/src/api/';

    // Modal state
    const showModal = ref(false);
    const isEditMode = ref(false);
    const modalForm = ref({
      product_id: null,
      name: '',
      category: '',
      price: 0,
      grams: 0,
      image_url: ''
    });

    // Computed for filtered products based on search
    const filteredProducts = computed(() => {
      if (!searchQuery.value.trim()) {
        return productsList.value;
      }
      const query = searchQuery.value.toLowerCase().trim();
      return productsList.value.filter(product => 
        product.name.toLowerCase().includes(query) || 
        product.category.toLowerCase().includes(query)
      );
    });

    // Helper to set active and fetch
    function setActiveAndFetch(tab) {
      active.value = tab;
      if (tab === 'producten') {
        fetchProducts();
      }
    }

    // Fetch products
    async function fetchProducts() {
      loadingProducts.value = true;
      try {
        const res = await fetch(baseUrl + 'products.php?action=list', { method: 'GET' });
        const data = await res.json();
        if (data.success) {
          productsList.value = data.products.map(p => ({
            ...p,
            price: parseFloat(p.price),
            grams: parseInt(p.grams, 10)
          }));
          products.value = productsList.value.length;
        } else {
          alert('Fout bij ophalen: ' + (data.message || ''));
          productsList.value = [];
          products.value = 0;
        }
      } catch (err) {
        alert('Netwerkfout: ' + err.message);
      } finally {
        loadingProducts.value = false;
      }
    }

    // Filter products on search input
    function filterProducts() {
      console.log('Searching for:', searchQuery.value);
    }

    // Open modal for add
    function openAddModal() {
      isEditMode.value = false;
      modalForm.value = { product_id: null, name: '', category: '', price: 0, grams: 0, image_url: '' };
      showModal.value = true;
    }

    // Open modal for edit
    function openEditModal(product) {
      isEditMode.value = true;
      modalForm.value = {
        product_id: product.product_id,
        name: product.name,
        category: product.category,
        price: product.price,
        grams: product.grams,
        image_url: product.image_url
      };
      showModal.value = true;
    }

    // Close modal
    function closeModal() {
      showModal.value = false;
    }

    // Save 
    async function saveProduct() {
      const formData = new URLSearchParams();
      formData.append('action', isEditMode.value ? 'update' : 'add');
      formData.append('name', modalForm.value.name);
      formData.append('category', modalForm.value.category);
      formData.append('price', modalForm.value.price);
      formData.append('grams', modalForm.value.grams);
      formData.append('image_url', modalForm.value.image_url);
      if (isEditMode.value) formData.append('product_id', modalForm.value.product_id);

      try {
        const res = await fetch(baseUrl + 'products.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: formData
        });
        const data = await res.json();
        if (data.success) {
          alert(data.message);
          closeModal();
          fetchProducts(); // Refresh list
        } else {
          alert('Fout: ' + data.message);
        }
      } catch (err) {
        alert('Netwerkfout: ' + err.message);
      }
    }

    // Delete product 
    async function deleteProduct(product) {
      if (confirm(`Weet je zeker dat je product "${product.name}" wilt verwijderen?`)) {
        const formData = new URLSearchParams();
        formData.append('action', 'delete');
        formData.append('product_id', product.product_id);

        try {
          const res = await fetch(baseUrl + 'products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData
          });
          const data = await res.json();
          if (data.success) {
            alert(data.message);
            fetchProducts(); // Refresh list after delete
          } else {
            alert('Fout bij verwijderen: ' + data.message);
          }
        } catch (err) {
          alert('Netwerkfout: ' + err.message);
        }
      }
    }

    function view(order) { alert('Bekijk #' + order.id); }
    function editKlant(klant) { alert('Bewerk #' + klant.id); }
    function deleteKlant(klant) { if (confirm('Verwijderen?')) klantenList.value = klantenList.value.filter(k => k.id !== klant.id); }
    function handleLogout() { localStorage.removeItem('user'); alert('Uitgelogd!'); window.location.reload(); }

    return { 
      omzet, totalOrders, products, orders, view, active, 
      productsList, filteredProducts, searchQuery, loadingProducts,
      klantenList, editKlant, deleteKlant,
      handleLogout, setActiveAndFetch,
      showModal, openAddModal, openEditModal, closeModal, saveProduct, modalForm, isEditMode,
      deleteProduct, filterProducts
    };
  }
}
</script>

<style scoped>
:root{
  --bg:#fafafa;
  --card-bg:#fff;
  --muted:#6b7280;
  --accent:#111827;
  --green:#dff3e8;
  --yellow:#fff7d6;
}

html,body{height:100%;}
.page-bg{min-height:100vh; background:var(--bg); font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, Arial;}
.container{ max-width:980px; margin:36px auto; padding:0 16px; }
.page-title{ font-size:13px; color:#374151; margin-bottom:18px; }

.metrics{ display:flex; gap:18px; margin-bottom:18px; }
.stat-card{ background:var(--card-bg); border:1px solid rgba(16,24,40,0.04); border-radius:10px; padding:18px; display:flex; gap:12px; align-items:center; flex:1; }
.stat-icon{ width:44px; height:44px; background:#eef7f0; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:18px; color:var(--accent); }
.stat-body{ text-align:left; }
.stat-label{ font-size:12px; color:var(--muted); }
.stat-value{ font-size:22px; color:#111827; margin-top:4px; }
.stat-sub{ font-size:11px; color:var(--muted); margin-top:2px; }

.segmented{ margin:18px 0; display: flex; align-items: center; }
.seg-btn{ border-radius:8px; border:1px solid rgba(16,24,40,0.06); padding:8px 14px; background:#fff; margin-right:8px; cursor:pointer; }
.seg-btn.active{ background:#0f172a; color:#fff; }
.search-input { 
  margin-left: auto; 
  padding: 8px; 
  border: 1px solid rgba(16,24,40,0.06); 
  border-radius: 8px; 
  min-width: 200px;
}

.panel{ background:transparent; }
.panel-title{ background:var(--card-bg); padding:16px 18px; border-radius:10px 10px 0 0; border:1px solid rgba(16,24,40,0.04); margin:0 0 0; }
.table-wrap{ border:1px solid rgba(16,24,40,0.04); border-top:0; border-radius:0 0 10px 10px; overflow:hidden; }
.orders-table{ width:100%; border-collapse:collapse; background:#fff; }
.orders-table th, .orders-table td{ padding:14px 18px; text-align:left; font-size:13px; border-top:1px solid rgba(15,23,42,0.03); }
.orders-table thead th{ border-top:0; color:#374151; }
.orders-table tbody tr td.center{ text-align:center; }

.badge{ padding:6px 10px; border-radius:999px; font-size:12px; display:inline-block; }
.badge.voltooid{ background:#e6f5ea; color:#047857; }
.badge.inbehandeling{ background:#eef2ff; color:#3730a3; }
.badge.inafwachting{ background:#fff7d6; color:#92400e; }

.orders-table a{ color:#111827; text-decoration:none; }

.btn-add { margin-bottom: 16px; padding: 8px 14px; background: #0f172a; color: #fff; border: none; border-radius: 8px; cursor: pointer; }

/* Modal styles */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex; align-items: center; justify-content: center;
  z-index: 1000;
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
  max-width: 90%;
}
.modal-content h3 { margin-top: 0; }
.modal-content label { display: block; margin: 10px 0 5px; font-weight: bold; }
.modal-content input {
  width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;
}
.modal-actions { margin-top: 20px; display: flex; gap: 10px; }
.modal-actions button {
  padding: 8px 16px; background: #0f172a; color: white; border: none; border-radius: 4px; cursor: pointer;
}
.modal-actions button[type="button"] { background: #ccc; color: black; }
</style>