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
      <router-link to="/login" class="profile-icon" aria-label="Login">
        <i class="fa-solid fa-user"></i>
      </router-link>

      <!-- Cart icon -->
      <router-link to="/cart" class="cart-icon" aria-label="Cart">
        <i class="fa-solid fa-cart-shopping"></i>
      </router-link>
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
  position: relative; 
}

.logo {
  font-size: 24px;
  font-weight: bold;
  color: #111;
}

nav {
  flex: 1;
  text-align: center;
}

nav a {
  margin: 0 15px;
  text-decoration: none;
  color: #111;
  font-weight: 500;
  cursor: pointer;
  transition: transform 0.3s ease, color 0.12s ease;
}

.icons {
  display: flex;
  align-items: center;
  gap: 15px;
  font-size: 18px;
  cursor: pointer;
  min-width: 140px;
  justify-content: flex-end;
}

.search-container input {
  padding: 5px 10px;
  border-radius: 999px;
  border: 1px solid #ccc;
  width: 220px;
}

.search-container {
  position: absolute;
  right: 120px; 
  top: 50%;
  transform: translateY(-50%);
  z-index: 60;
}

.cart-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: inherit; 
  text-decoration: none;
}
.cart-icon:focus {
  outline: none;
}
.cart-icon i {
  color: #111; 
}

.profile-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: inherit;
  text-decoration: none;
}
.profile-icon:focus {
  outline: none;
}
.profile-icon i {
  color: #111;
}

.cart-icon.router-link-active i,
.profile-icon.router-link-active i {
  color: #111 !important;
}

@media (max-width: 768px) {
  .search-container {
    position: static;
    transform: none;
    right: auto;
    width: 100%;
    margin-right: 10px;
  }
  .search-container input {
    width: 100%;
  }
}
nav a.router-link-active {
  font-weight: 800; 
  transform: scale(1.03);
  color: #2d7a4f; 
  
}
</style>
