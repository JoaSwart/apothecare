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
        <button :class="['seg-btn', active === 'producten' ? 'active' : '']" @click="active='producten'">Producten</button>
        <button :class="['seg-btn', active === 'klanten' ? 'active' : '']" @click="active='klanten'">Klanten</button>
        <input type="text" placeholder="Search" class="search-input" />
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
        <button @click="addProduct" class="btn-add">+ Product toevoegen</button>

        <div class="table-wrap">
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
              <tr v-for="product in productsList" :key="product.id">
                <td>{{ product.naam }}</td>
                <td>{{ product.categorie }}</td>
                <td>€{{ product.prijs.toFixed(2) }}</td>
                <td>{{ product.gram }}g</td>
                <td>
                  <img :src="product.afbeelding" alt="Product afbeelding" style="width: 50px; height: auto;" />
                </td>
                <td>
                  <a href="#" @click.prevent="editProduct(product)">Bewerken</a> |
                  <a href="#" @click.prevent="deleteProduct(product)">Delete</a>
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
                <th>Totaal besteed</th>
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
                <td class="center">€{{ klant.totaalBesteed.toFixed(2) }}</td>
                <td>
                  <a href="#" @click.prevent="editKlant(klant)">Bewerken</a> |
                  <a href="#" @click.prevent="deleteKlant(klant)">Verwijderen</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

    </main>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  name: 'DashBoard',
  setup() {
    const omzet = ref(930);
    const totalOrders = ref(0); // Will set from data
    const products = ref(0); // Will set from data
    const active = ref('bestellingen');

    const orders = ref([
      { id:1, name:'Jan de Vries', contact:'jan@email.com', items:3, date:'14 okt 2025', status:'Voltooid', statusClass:'voltooid' },
      { id:2, name:'Maria Bakker', contact:'maria@email.com', items:1, date:'13 okt 2025', status:'In behandeling', statusClass:'inbehandeling' },
      { id:3, name:'Piet Jansen', contact:'piet@email.com', items:5, date:'12 okt 2025', status:'In afwachting', statusClass:'inafwachting' },
    ]);

    // Sample products data (replace with API fetch later)
    const productsList = ref([
      { id: 1, naam: 'Paracetamol', categorie: 'Pijnstillers', prijs: 2.99, gram: 500, afbeelding: 'https://via.placeholder.com/50?text=Para' },
      { id: 2, naam: 'Vitamine C', categorie: 'Supplementen', prijs: 5.49, gram: 1000, afbeelding: 'https://via.placeholder.com/50?text=VitC' },
      { id: 3, naam: 'Ibuprofen', categorie: 'Pijnstillers', prijs: 3.99, gram: 200, afbeelding: 'https://via.placeholder.com/50?text=Ibu' },
    ]);

    // Sample customers data (replace with API fetch later)
    const klantenList = ref([
      { 
        id: 1, 
        naam: 'Jan de Vries', 
        email: 'jan@email.com', 
        telefoon: '06-12345678',
        registratiedatum: '12 okt 2025',
        bestellingen: 3,
        totaalBesteed: 89.50
      },
      { 
        id: 2, 
        naam: 'Maria Bakker', 
        email: 'maria@email.com', 
        telefoon: '06-87654321',
        registratiedatum: '10 okt 2025',
        bestellingen: 1,
        totaalBesteed: 15.99
      },
      { 
        id: 3, 
        naam: 'Piet Jansen', 
        email: 'piet@email.com', 
        telefoon: '',
        registratiedatum: '08 okt 2025',
        bestellingen: 5,
        totaalBesteed: 234.75
      },
    ]);

    // Set stats from data
    totalOrders.value = orders.value.length;
    products.value = productsList.value.length;

    function view(order) {
      alert('Bekijk order #' + order.id + ' (demo)');
    }

    // Product actions (demo alerts)
    function addProduct() {
      alert('Nieuw product toevoegen (demo)');
    }

    function editProduct(product) {
      alert('Bewerk product #' + product.id + ' (demo)');
    }

    function deleteProduct(product) {
      if (confirm('Weet je zeker dat je product #' + product.id + ' wilt verwijderen?')) {
        // Simulate delete
        productsList.value = productsList.value.filter(p => p.id !== product.id);
        products.value = productsList.value.length;
        alert('Product verwijderd (demo)');
      }
    }

    // Customer actions (demo alerts)
    function editKlant(klant) {
      alert('Bewerk klant #' + klant.id + ' (demo)');
    }

    function deleteKlant(klant) {
      if (confirm('Weet je zeker dat je klant #' + klant.id + ' wilt verwijderen?')) {
        // Simulate delete
        klantenList.value = klantenList.value.filter(k => k.id !== klant.id);
        alert('Klant verwijderd (demo)');
      }
    }

    // Simplified logout
    function handleLogout() {
      localStorage.removeItem('user'); // Clear
      alert('Uitgelogd!');
      window.location.reload(); // Quick switch back
    }

    return { 
      omzet, totalOrders, products, orders, view, active, 
      productsList, addProduct, editProduct, deleteProduct,
      klantenList, editKlant, deleteKlant,
      handleLogout 
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
.search-input { margin-left: auto; padding: 8px; border: 1px solid rgba(16,24,40,0.06); border-radius: 8px; }

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
</style>