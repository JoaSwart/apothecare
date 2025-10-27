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
        <input type="text" placeholder="Search products..." />
        <i @click="toggleSearch" class="fa-solid fa-magnifying-glass"></i>
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
    };
  },
  methods: {
    toggleSearch() {
      this.isSearchVisible = !this.isSearchVisible;
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
