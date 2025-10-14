const app = Vue.createApp({})
        app.component('site-header', {
            data() {
                return {
                    isSearchVisible: false
                }
            },
            methods: {
                toggleSearch() {
                    this.isSearchVisible = !this.isSearchVisible;
                }
            },
            template: `
            <header>
                <h2 class="logo">apothecare</h2>
                <nav>
                    <a href="#">Home</a>
                    <a href="#">Products</a>
                    <a href="#">Cart</a>
                </nav>
                <div class="icons">
                   <div v-if="isSearchVisible" class="search-container">
                        <input type="text" placeholder="Zoek producten...">
                        <i @click="toggleSearch" class="fa-solid fa-magnifying-glass"></i>
                   </div>
                   <i v-else @click="toggleSearch" class="fa-solid fa-magnifying-glass"></i>
                   <i class="fa-solid fa-user"></i>
                    <i class="fa-solid fa-cart-shopping"></i>
                   
                </div>
            </header>
            `
        })
        app.mount('#app')