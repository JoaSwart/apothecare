<template>
  <div id="app">
    <!-- Site Header - always visible -->
    <SiteHeader 
      @open-login="handleOpenLogin" 
      @go-home="goHome"
      @go-products="goProducts"
      @go-cart="goCart"
    />

    <!-- Page transitions -->
    <transition name="fade" mode="out-in">
      <div :key="currentPage" class="page-content">
        <!-- Checkout should show regardless of login state -->
        <CheckoutPage
          v-if="currentPage === 'checkout'"
          :items="[]"
          key="checkout-top"
          @back="goCart"
        />

        <!-- Login modal can be shown regardless of login state (used for account/settings) -->
        <LoginPage
          v-if="showLogin"
          @login-success="handleLoginSuccess"
          key="login"
        />

        <!-- If user not logged in: show landing/products/cart as before -->
        <template v-if="!loggedInUser">
          <LandingPage
            v-if="currentPage === 'landing'"
            @go-to-login="showLogin = true"
            key="landing"
          />
          <ProductenOverzicht
            v-if="currentPage === 'products'"
            key="products"
          />
          <CartPage
            v-if="currentPage === 'cart'"
            key="cart"
            @checkout="goCheckout"
          />
        </template>

        <!-- If admin logged in (render only when currentPage is 'dashboard') -->
        <Dashboard
          v-else-if="loggedInUser && loggedInUser.is_admin && currentPage === 'dashboard'"
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

    <!-- Site Footer - always visible at bottom -->
    <SiteFooter />
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import LoginPage from './components/Login.vue';
import SiteHeader from './components/Header.vue';
import SiteFooter from './components/Footer.vue';
import Dashboard from './components/Dashboard.vue';
import LandingPage from './components/LandingPage.vue';
import ProductenOverzicht from './components/ProductenOverzicht.vue';
import CartPage from './components/Cart.vue';
import CheckoutPage from './components/Checkout.vue';

export default {
  name: 'App',
  components: { LoginPage, SiteHeader, SiteFooter, Dashboard, LandingPage, ProductenOverzicht, CartPage, CheckoutPage },
  setup() {
    const loggedInUser = ref(null);
    const showLogin = ref(false);
    const currentPage = ref('landing'); // Track which page to show

    const checkLogin = () => {
      const userJson = localStorage.getItem('user');
      loggedInUser.value = userJson ? JSON.parse(userJson) : null;
    };

    const handleOpenLogin = () => {
      // If admin is logged in, go to dashboard instead of showing login modal
      if (loggedInUser.value && loggedInUser.value.is_admin) {
        showLogin.value = false;
        currentPage.value = 'dashboard';
        return;
      }
      // Otherwise show login modal
      showLogin.value = true;
    };

    const handleLoginSuccess = () => {
      checkLogin();
      showLogin.value = false;
      // If admin, go to dashboard; otherwise show landing
      currentPage.value = (loggedInUser.value && loggedInUser.value.is_admin) ? 'dashboard' : 'landing';
    };

    const goHome = () => {
      showLogin.value = false; // hide login modal if open
      // Home button should always go to the landing page
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

    onMounted(() => {
      checkLogin();
      if (loggedInUser.value && loggedInUser.value.is_admin) {
        currentPage.value = 'dashboard';
      }
    });

    return { loggedInUser, showLogin, handleLoginSuccess, currentPage, goHome, goProducts, goCart, goCheckout, handleOpenLogin };
  },
};
</script>

<style>
#app {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
  display: flex;
  min-height: 100vh; /* ensure full viewport height */
  flex-direction: column;
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

/* make main content take remaining space so footer stays at bottom */
.page-content {
  flex: 1 0 auto;
}

.site-footer {
  flex-shrink: 0;
}
</style>
