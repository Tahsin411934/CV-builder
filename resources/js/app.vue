<template>
    <div class="max-w-1260 mx-auto ">
       <navbar/>
        <router-view></router-view>
        <Footer/>
    </div>
</template>

<script>
import Navbar from './components/Home/Navbar.vue';
import Footer from './components/Footer.vue';
export default {
  components: { Navbar, Footer },
    name: 'App',
};
</script>
