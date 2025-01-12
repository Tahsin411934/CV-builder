import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'; // Ensure this is your root Vue component
import router from './router'; // Import the router
// Import Bootstrap CSS
import 'bootstrap/dist/css/bootstrap.min.css';

// Import Bootstrap JS
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const app = createApp(App);
const isAuthenticated = () => {
    return !!localStorage.getItem('token'); // Replace with actual auth logic
  };
console.log(isAuthenticated());
// Add navigation guard
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !isAuthenticated()) {
      
      next({ name: 'Login' });
    } else {
      
      next();
    }
  });
app.use(router); // Register the router
app.mount('#app');
