<template>
    <div class="max-w-1260 mx-auto">
       <navbar/>
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from './components/Home/Navbar.vue';
export default {
  components: { Navbar },
    name: 'App',
};
</script>
