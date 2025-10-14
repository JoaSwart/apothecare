const { createApp, ref } = Vue;

createApp({
	setup() {
		const actief = ref('login');
		const email = ref('');
		const wachtwoord = ref('');
		const name = ref('');
		const confirmwachtwoord = ref('');
		const isBeheerder = ref(false);
        const subtitle = ref('Log in of maak een account aan');

				function submit() {
					// Register flow
					if (actief.value === 'register') {
						if (!name.value || !email.value || !wachtwoord.value || !confirmwachtwoord.value) {
							alert('Vul alle velden in.');
							return;
						}
						if (wachtwoord.value !== confirmwachtwoord.value) {
							alert('Wachtwoorden komen niet overeen.');
							return;
						}

						// TODO: call API to register
						alert(`Registratie succesvol: ${name.value}`);
						// after register, optionally switch to login
						actief.value = 'login';
						name.value = '';
						email.value = '';
						wachtwoord.value = '';
						confirmwachtwoord.value = '';
						return;
					}

					// Login flow
					if (!isBeheerder.value && email.value === 'klant@test.nl' && wachtwoord.value === 'test123') {
						alert('Inloggen succesvol (demo klant)');
						return;
					}

					if (isBeheerder.value && email.value === 'admin' && wachtwoord.value === 'admin123') {
						alert('Inloggen succesvol (demo beheerder)');
						return;
					}

					if (!email.value || !wachtwoord.value) {
						alert('Vul gebruikersnaam/e-mail en wachtwoord in.');
						return;
					}

					// TODO: replace with real API call
					alert(`Submitted: ${email.value}`);
				}

			function cancel() {
				name.value = '';
				email.value = '';
				wachtwoord.value = '';
				confirmwachtwoord.value = '';
			}

			function toggleBeheerder(){
				isBeheerder.value = !isBeheerder.value;
				email.value = '';
				wachtwoord.value = '';
                
			}

			return { actief, email, wachtwoord, isBeheerder, submit, cancel, toggleBeheerder, subtitle };
	}
}).mount('#app');
