<template>
  <div id="app">
    <!-- Site Header - always visible -->
    <SiteHeader @open-login="showLogin = true" />

    <!-- If user not logged in -->
    <template v-if="!loggedInUser">
      <!-- Show login if user icon clicked -->
      <LoginPage
        v-if="showLogin"
        @login-success="handleLoginSuccess"
      />

      <!-- Otherwise show landing -->
      <LandingPage
        v-else
        @go-to-login="showLogin = true"
      />
    </template>

    <!-- If admin logged in -->
    <template v-else-if="loggedInUser.is_admin">
      <Dashboard :user="loggedInUser" />
    </template>

    <!-- If regular user logged in -->
    <template v-else>
      <LandingPage :user="loggedInUser" />
    </template>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import LoginPage from './components/Login.vue';
import SiteHeader from './components/Header.vue';
import Dashboard from './components/Dashboard.vue';
import LandingPage from './components/LandingPage.vue';

export default {
  name: 'App',
  components: {
    LoginPage,
    SiteHeader,
    Dashboard,
    LandingPage,
  },
  setup() {
    const loggedInUser = ref(null);
    const showLogin = ref(false);

    function checkLogin() {
      const userJson = localStorage.getItem('user');
      if (userJson) {
        loggedInUser.value = JSON.parse(userJson);
      } else {
        loggedInUser.value = null;
      }
    }

    onMounted(checkLogin);

    function handleLoginSuccess() {
      checkLogin();
      showLogin.value = false;
    }

    return { loggedInUser, showLogin, handleLoginSuccess };
  },
};
</script>

<style>
#app {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
}
</style>
