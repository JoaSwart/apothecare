<template>
  <div id="app">
    <!-- Site Header -->
    <SiteHeader />

    <!-- Login Page -->
    <LoginPage />
  </div>
</template>

<script>
import LoginPage from './components/Login.vue'
import SiteHeader from './components/Header.vue'

export default {
  name: 'App',
  components: {
    LoginPage,
    SiteHeader
  }
}
</script>

<style>
/* Optional global styles */
#app {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
}
</style>