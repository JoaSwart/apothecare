<template>
  <div id="app">
    <SiteHeader @open-login="handleOpenLogin" />

    <router-view v-slot="{ Component }">
      <transition name="fade" mode="out-in">
        <component :is="Component" :key="$route.path" :user="loggedInUser" class="page-content" />
      </transition>
    </router-view>

    <SiteFooter />

    <ChatWidget v-if="showChat" />
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import SiteHeader from './components/Header.vue';
import SiteFooter from './components/Footer.vue';
import ChatWidget from './components/ChatWidget.vue';

export default {
  name: 'App',
  components: { SiteHeader, SiteFooter, ChatWidget },
  setup() {
    const loggedInUser = ref(null);
    const router = useRouter();
    const route = useRoute();

    const checkLogin = () => {
      const userJson = localStorage.getItem('user');
      loggedInUser.value = userJson ? JSON.parse(userJson) : null;
    };

    const handleOpenLogin = () => {
      if (loggedInUser.value && loggedInUser.value.is_admin) {
        router.push('/dashboard');
        return;
      }
      router.push('/login'); // navigate to login page
    };

    const showChat = computed(() => {
      try {
        return route.name === 'Producten' || (route.path && route.path.startsWith('/producten'));
      } catch (e) {
        return false;
      }
    });

    onMounted(() => {
      checkLogin();
    });

    return { loggedInUser, handleOpenLogin, showChat };
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
