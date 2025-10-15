<template>
  <div id="log" class="page-bg">
    <div class="login-card">
      <div class="avatar-wrap">
        <img src="../assets/avatar-placeholder.svg" alt="avatar" class="avatar">
      </div>
      <h3 class="title">Welkom bij Apothecare</h3>
      <p class="subtitle">{{ subtitle }}</p>

      <div class="tabs" v-if="!isBeheerder">
        <button :class="['tab', actief === 'login' ? 'active' : '']" @click="actief = 'login'">Inloggen</button>
        <button :class="['tab', actief === 'register' ? 'active' : '']" @click="actief = 'register'">Registreren</button>
      </div>

      <form class="form" @submit.prevent="submit">
        <!-- Registreren -->
        <template v-if="actief === 'register'">
          <label class="label">Naam</label>
          <input v-model="name" type="text" placeholder="Uw naam" class="input">

          <label class="label">E-mailadres</label>
          <input v-model="email" type="email" placeholder="uw@email.nl" class="input">

          <label class="label">Wachtwoord</label>
          <input v-model="wachtwoord" type="password" class="input">

          <label class="label">Bevestig wachtwoord</label>
          <input v-model="confirmwachtwoord" type="password" class="input">

          <div class="buttons-row">
            <button type="button" class="btn btn-ghost" @click="cancel">Annuleren</button>
            <button type="submit" class="btn btn-primary">Registreren</button>
          </div>
        </template>

        <!-- Login -->
        <template v-if="actief === 'login'">
          <label class="label">{{ isBeheerder ? 'Gebruikersnaam' : 'E-mailadres' }}</label>
          <input v-model="email" :type="isBeheerder ? 'text' : 'email'" :placeholder="isBeheerder ? 'gebruikersnaam' : 'uw@email.nl'" class="input">

          <label class="label">Wachtwoord</label>
          <input v-model="wachtwoord" type="password" class="input">

          <div class="buttons-row">
            <button type="button" class="btn btn-ghost" @click="cancel">Annuleren</button>
            <button type="submit" class="btn btn-primary">Inloggen</button>
          </div>
        </template>
      </form>

      <div class="footer-link">
        <a href="#" @click.prevent="toggleBeheerder">{{ isBeheerder ? 'Terug naar inloggen' : 'Bent u beheerder? Klik hier →' }}</a>
      </div>
    </div>
  </div>
</template>


<script>
import { ref, getCurrentInstance } from 'vue';

export default {
  name: "LoginPage",
  setup() {
    const actief = ref('login');
    const email = ref('');
    const wachtwoord = ref('');
    const name = ref('');
    const confirmwachtwoord = ref('');
    const isBeheerder = ref(false);
    const subtitle = ref('Log in of maak een account aan');

    const baseUrl = 'http://localhost/Projectweek%20october/apothecare/apothecare_with-vue/src/api/';
    const { emit } = getCurrentInstance();

    async function submit() {
      if (actief.value === 'register') {
        if (!name.value || !email.value || !wachtwoord.value || !confirmwachtwoord.value) {
          alert('Vul alle velden in.');
          return;
        }
        if (wachtwoord.value !== confirmwachtwoord.value) {
          alert('Wachtwoorden komen niet overeen.');
          return;
        }

        const formData = new FormData();
        formData.append('name', name.value);
        formData.append('email', email.value);
        formData.append('password', wachtwoord.value);

        try {
          const res = await fetch(baseUrl + 'register.php', {
            method: 'POST',
            body: formData
          });
          const data = await res.json();
          alert(data.message);
          if (data.success) {
            actief.value = 'login';
            cancel();
          }
        } catch (err) {
          alert('Fout bij registratie: ' + err.message);
        }
        return;
      }

      // LOGIN
      if (!email.value || !wachtwoord.value) {
        alert('Vul gebruikersnaam/e-mail en wachtwoord in.');
        return;
      }

      const formData = new FormData();
      formData.append('email', email.value);
      formData.append('password', wachtwoord.value);

      try {
        const res = await fetch(baseUrl + 'login.php', {
          method: 'POST',
          body: formData
        });
        const data = await res.json();

        if (data.success) {
          alert(`Inloggen succesvol! ${data.is_admin ? 'Admin' : 'Klant'}`);

          localStorage.setItem('user', JSON.stringify({
            user_id: data.user_id,
            username: data.username,
            is_admin: data.is_admin
          }));

          emit('login-success');
        } else {
          alert(data.message);
        }
      } catch (err) {
        alert('Fout bij inloggen: ' + err.message);
      }
    }

    function cancel() {
      name.value = '';
      email.value = '';
      wachtwoord.value = '';
      confirmwachtwoord.value = '';
    }

    function toggleBeheerder() {
      isBeheerder.value = !isBeheerder.value;
      email.value = '';
      wachtwoord.value = '';
    }

    return { actief, email, wachtwoord, isBeheerder, name, confirmwachtwoord, subtitle, submit, cancel, toggleBeheerder };
  }
}
</script>




<style scoped>
/* Page background */
:root{
	--bg: #f4f5f5;
	--card-bg: #fff;
	--muted: #6b7280;
	--accent: #2f6f4e;
	--input-bg: #f6f8fa;
}

html,body{
	height:100%;
}

.page-bg{
	min-height:100vh;
	display:flex;
	align-items:center;
	justify-content:center;
	background:var(--bg);
	font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
}

.login-card{
	width:420px;
	background:var(--card-bg);
	border-radius:10px;
	padding:28px 32px 22px;
	box-shadow: 0 1px 0 rgba(0,0,0,0.05), 0 6px 20px rgba(10,10,10,0.04);
	border:1px solid rgba(16,24,40,0.04);
	text-align:center;
}

.avatar-wrap{ display:flex; justify-content:center; }
.avatar{ width:64px; height:64px; }

.title{ margin:14px 0 4px; font-size:15px; color:#111827; }
.subtitle{ margin:0 0 14px; font-size:12px; color:var(--muted); }

.tabs{ display:flex; gap:8px; justify-content:center; margin:10px 0 12px; }
.tab{ flex:1 1 0; max-width:180px; padding:8px 12px; border-radius:16px; background:transparent; border:0; cursor:pointer; font-size:13px; color:var(--muted); }
.tab.active{ background:#f2f4f5; color:#176635; box-shadow: inset 0 -1px 0 rgba(0,0,0,0.03); }

.form{ text-align:left; }
.label{ display:block; margin:8px 0 6px; font-size:13px; color:#111827; }
.input{ width:100%; padding:10px 12px; border-radius:6px; border:1px solid rgba(15,23,42,0.05); background:var(--input-bg); box-sizing:border-box; }

.demo-box{ margin-top:12px; background:#f3f4f6; border-radius:6px; padding:12px; font-size:13px; color:#374151; }

.buttons-row{ display:flex; gap:12px; margin-top:14px; }
.btn{ padding:8px 12px; border-radius:6px; font-size:13px; cursor:pointer; flex:1 1 0; }
.btn-ghost{ background:white; border:1px solid rgba(15,23,42,0.08); color:#111827; }
.btn-primary{ background:var(--accent); color:#fff; border:0; }

.footer-link{ margin-top:16px; font-size:13px; color:var(--muted); text-align:center; }

@media (max-width:450px){
	.login-card{ width:92%; padding:20px; }
}
</style>
