vue /* eslint-disable vue/multi-word-component-names */

<template>
  <div id="app">
    <!-- Site Header - show always -->
    <SiteHeader />

    <Producten />

    <!-- Get logged-in user from localStorage -->
    <template v-if="loggedInUser && loggedInUser.is_admin">
      <Dashboard :user="loggedInUser" />
      <!-- Only show if admin -->
    </template>
    <template v-else>
      <LoginPage @login-success="handleLoginSuccess" />
    </template>
  </div>
</template>

<script>
import { ref, onMounted } from "vue"; // Add onMounted for refresh check
import LoginPage from "./components/Login.vue";
import SiteHeader from "./components/Header.vue";
import Dashboard from "./components/Dashboard.vue";
import Producten from "./components/ProductenOverzicht.vue";

/* eslint-disable vue/multi-word-component-names */

export default {
  name: "App",
  components: {
    LoginPage,
    SiteHeader,
    Dashboard,
    Producten,
  },
  setup() {
    const loggedInUser = ref(null); // Holds user object or null

    // Function to check storage (call on load and after login)
    function checkLogin() {
      const userJson = localStorage.getItem("user");
      if (userJson) {
        const user = JSON.parse(userJson);
        if (user.is_admin) {
          // Only set if admin (boolean check)
          loggedInUser.value = user;
        } else {
          // For non-admins: Clear storage and alert
          localStorage.removeItem("user");
          loggedInUser.value = null;
          alert(
            "Alleen beheerders kunnen toegang krijgen tot het dashboard. Log in als beheerder."
          );
        }
      } else {
        loggedInUser.value = null;
      }
    }

    // Check on app load/refresh
    onMounted(checkLogin);

    // Call this after successful login (emitted from Login)
    function handleLoginSuccess() {
      checkLogin(); // Re-check storage to switch view
    }

    return { loggedInUser, handleLoginSuccess };
  },
};
</script>

<style>
/* Optional global styles */
#app {
  font-family: "Poppins", sans-serif;
  margin: 0;
  padding: 0;
}
</style>
