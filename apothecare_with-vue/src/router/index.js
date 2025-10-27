import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../components/LandingPage.vue';
import ProductenOverzicht from '../components/ProductenOverzicht.vue'; 
import Cart from '../components/Cart.vue';
import Dashboard from '../components/Dashboard.vue'; 
import LoginPage from '../components/Login.vue';
import CheckoutPage from '../components/Checkout.vue';

const routes = [
  {
    path: '/', 
    name: 'Home',
    component: LandingPage 
  },
  {
    path: '/producten', 
    name: 'Producten',
    component: ProductenOverzicht 
  },
  {
    path: '/cart',
    name: 'Cart',
    component: Cart
  },
  {
    path: '/dashboard', 
    name: 'Dashboard',
    component: Dashboard
  },
  {
    path: '/checkout',
    name: 'Checkout',
    component: CheckoutPage
  },
  {
    path: '/login',        
    name: 'Login',
    component: LoginPage
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes, 
});

export default router;
