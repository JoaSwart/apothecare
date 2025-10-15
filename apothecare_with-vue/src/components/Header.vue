<template>
  <header>
    <h2 class="logo">apothecare</h2>

    <nav>
      <a href="#">Home</a>
      <a href="#">Products</a>
      <a href="#">Cart</a>
    </nav>

    <div class="icons">
      <!-- Search icon / input -->
      <div v-if="isSearchVisible" class="search-container">
        <input type="text" placeholder="Search products..." />
        <i @click="toggleSearch" class="fa-solid fa-magnifying-glass"></i>
      </div>
      <i v-else @click="toggleSearch" class="fa-solid fa-magnifying-glass"></i>

      <!-- User icon -->
      <i class="fa-solid fa-user" @click="$emit('open-login')"></i>

      <!-- Cart icon -->
      <i class="fa-solid fa-cart-shopping"></i>
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
  justify-content: space-between;
  align-items: center;
  padding: 15px 5%;
  background-color: #fff;
  border-bottom: 1px solid #e0e0e0;
}

.logo {
  font-size: 24px;
  font-weight: 700;
  color: #333;
}

nav {
  display: flex;
  gap: 40px;
}

nav a {
  text-decoration: none;
  color: #333;
  font-weight: 500;
  font-size: 16px;
  transition: color 0.2s;
}

nav a:hover {
  color: #6e906e;
}

.icons {
  display: flex;
  align-items: center;
  gap: 25px;
}

.icons i {
  font-size: 18px;
  color: #333;
  cursor: pointer;
  padding: 10px;
  border-radius: 8px;
  transition: background-color 0.2s, color 0.2s;
}

.icons i:hover {
  background-color: #6fb783;
  color: #fafafa;
}

.search-container {
  display: flex;
  align-items: center;
  border: 1px solid #6c946c;
  box-shadow: 0 0 0 3px rgba(108, 145, 108, 0.78);
  border-radius: 8px;
  padding: 7px 10px;
}

.search-container input {
  border: none;
  outline: none;
  background: transparent;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
}

.search-container i:hover {
  background-color: transparent;
  color: #333;
}
</style>
