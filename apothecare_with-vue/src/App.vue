
<template>
  <div id="app">
    <SiteHeader 
      @open-login="handleOpenLogin"
    />

    <LoginPage
      v-if="showLogin"
      @login-success="handleLoginSuccess"
    />

    <router-view v-slot="{ Component }">
      <transition name="fade" mode="out-in">
        <component :is="Component" :key="$route.path" :user="loggedInUser" class="page-content" />
      </transition>
    </router-view>

    <SiteFooter />
  </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router'; // Import router hooks
import LoginPage from './components/Login.vue';
import SiteHeader from './components/Header.vue';
import SiteFooter from './components/Footer.vue';

export default {
  name: 'App',
  components: { LoginPage, SiteHeader, SiteFooter },
  setup() {
    const loggedInUser = ref(null);
    const showLogin = ref(false);
    
    const router = useRouter(); // Get access to the router instance
    const route = useRoute();   // Get access to the current route info

    const checkLogin = () => {
      const userJson = localStorage.getItem('user');
      loggedInUser.value = userJson ? JSON.parse(userJson) : null;
    };

    const handleOpenLogin = () => {
      if (loggedInUser.value && loggedInUser.value.is_admin) {
        router.push('/dashboard'); 
        return;
      }
      showLogin.value = true;
    };

    const handleLoginSuccess = () => {
      checkLogin();
      showLogin.value = false;
      if (loggedInUser.value && loggedInUser.value.is_admin) {
        router.push('/dashboard');
      } else {
        router.push('/'); 
      }
    };

    onMounted(() => {
      checkLogin();
    });
    
    watch(() => route.path, () => {
      showLogin.value = false;
    });

    return { 
      loggedInUser, 
      showLogin, 
      handleLoginSuccess, 
      handleOpenLogin 
    };
  },
};
</script>

<style>
#app {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
  display: flex;
  min-height: 100vh;
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

.page-content {
  flex: 1 0 auto;
}

.site-footer {
  flex-shrink: 0;
}
</style>