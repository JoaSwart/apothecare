<template>
  <div id="app">
    <!-- Site Header - always visible -->
    <SiteHeader 
      @open-login="showLogin = true" 
      @go-home="goHome"
      @go-products="goProducts"
      @go-cart="goCart"
    />

    <!-- Page transitions -->
    <transition name="fade" mode="out-in">
      <div :key="currentPage">
        <!-- Checkout should show regardless of login state -->
        <CheckoutPage
          v-if="currentPage === 'checkout'"
          :items="[]"
          key="checkout-top"
          @back="goCart"
        />

        <!-- If user not logged in -->
        <template v-if="!loggedInUser">
          <!-- Show login if user icon clicked -->
          <LoginPage
            v-if="showLogin"
            @login-success="handleLoginSuccess"
            key="login"
          />
          <!-- Otherwise show landing or products -->
          <LandingPage
            v-else-if="currentPage === 'landing'"
            @go-to-login="showLogin = true"
            key="landing"
          />
          <ProductenOverzicht
            v-else-if="currentPage === 'products'"
            key="products"
          />
          <CartPage
            v-else-if="currentPage === 'cart'"
            key="cart"
            @checkout="goCheckout"
          />
        </template>

        <!-- If admin logged in -->
        <Dashboard
          v-else-if="loggedInUser.is_admin"
          :user="loggedInUser"
          key="dashboard"
        />

        <!-- If regular user logged in -->
        <LandingPage
          v-else-if="currentPage === 'landing'"
          :user="loggedInUser"
          key="user-landing"
        />
        <ProductenOverzicht
          v-else-if="currentPage === 'products'"
          :user="loggedInUser"
          key="user-products"
        />
        <CartPage
          v-else-if="currentPage === 'cart'"
          :user="loggedInUser"
          key="user-cart"
          @checkout="goCheckout"
        />
      </div>
    </transition>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import LoginPage from './components/Login.vue';
import SiteHeader from './components/Header.vue';
import Dashboard from './components/Dashboard.vue';
import LandingPage from './components/LandingPage.vue';
import ProductenOverzicht from './components/ProductenOverzicht.vue';
import CartPage from './components/Cart.vue';
import CheckoutPage from './components/Checkout.vue';

export default {
  name: 'App',
  components: { LoginPage, SiteHeader, Dashboard, LandingPage, ProductenOverzicht, CartPage, CheckoutPage },
  setup() {
    const loggedInUser = ref(null);
    const showLogin = ref(false);
    const currentPage = ref('landing'); // Track which page to show

    const checkLogin = () => {
      const userJson = localStorage.getItem('user');
      loggedInUser.value = userJson ? JSON.parse(userJson) : null;
    };

    const handleLoginSuccess = () => {
      checkLogin();
      showLogin.value = false;
      currentPage.value = 'landing'; // Go to landing after login
    };

    const goHome = () => {
      showLogin.value = false; // hide login modal if open
      currentPage.value = 'landing';
    };

    const goProducts = () => {
      showLogin.value = false; // hide login modal if open
      currentPage.value = 'products';
    };

    const goCart = () => {
      showLogin.value = false;
      currentPage.value = 'cart';
    };

    const goCheckout = () => {
      showLogin.value = false;
      currentPage.value = 'checkout'
    }

    onMounted(checkLogin);

    return { loggedInUser, showLogin, handleLoginSuccess, currentPage, goHome, goProducts, goCart, goCheckout };
  },
};
</script>

<style>
#app {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
}

/* Smooth fade animation for transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
