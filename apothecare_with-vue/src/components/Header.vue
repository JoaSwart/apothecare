<template>
  <header>
    <h2 class="logo">apothecare</h2>

    <nav>
       <router-link to="/">Home</router-link>
      <router-link to="/producten">Producten</router-link>
      <router-link to="/cart">Cart</router-link>
    </nav>

    <div class="icons">
      <!-- Search icon -->
      <div v-if="isSearchVisible" class="search-container">
        <form @submit.prevent="goToProducts" style="display:flex; align-items:center">
          <input ref="headerSearch" v-model="searchQuery" type="text" placeholder="Zoek producten..." />
          <button type="submit" style="background:transparent;border:none;color:inherit;cursor:pointer;padding:6px;">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </form>
      </div>
      <i v-else @click="toggleSearch" class="fa-solid fa-magnifying-glass"></i>

      <!-- User icon -->
      <i class="fa-solid fa-user" @click="$emit('open-login')"></i>

      <!-- Cart icon -->
      <i href="#" @click.prevent="$emit('go-cart')" class="fa-solid fa-cart-shopping"></i>
    </div>
  </header>
</template>

<script>
export default {
  name: 'SiteHeader',
  data() {
    return {
      isSearchVisible: false
      ,searchQuery: ''
    };
  },
  methods: {
    toggleSearch() {
      this.isSearchVisible = !this.isSearchVisible;
      this.$nextTick(() => {
        if (this.isSearchVisible && this.$refs.headerSearch) {
          this.$refs.headerSearch.focus();
        }
      });
    }
    ,goToProducts() {
      // navigate to producten route with query param 'q'
      const q = this.searchQuery ? String(this.searchQuery).trim() : '';
      this.$router.push({ name: 'Producten', query: q ? { q } : {} });
      // optionally hide the search input after navigating
      this.isSearchVisible = false;
    }
  }
};
</script>

<style scoped>
header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 40px;
  background-color: #fff;
  border-bottom: 1px solid #ddd;
  font-family: 'Poppins', sans-serif;
}

.logo {
  font-size: 24px;
  font-weight: bold;
  color: #111;
}

nav a {
  margin: 0 15px;
  text-decoration: none;
  color: #111;
  font-weight: 500;
  cursor: pointer;
}

.icons {
  display: flex;
  align-items: center;
  gap: 15px;
  font-size: 18px;
  cursor: pointer;
}

.search-container input {
  padding: 5px 10px;
  border-radius: 999px;
  border: 1px solid #ccc;
  width: 200px;
}
</style>
