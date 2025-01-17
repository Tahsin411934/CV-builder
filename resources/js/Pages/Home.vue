<template>
  <div>
    <Banner />
    <Services/>
    <Contact/>
  </div>
</template>

<script>
import Banner from '../components/Home/Banner.vue';
import Services from '../components/Home/Services.vue';
import Contact from '../components/Home/Contact.vue';

export default {
  components: { Banner, Services, Contact },
  name: "Home",
};
</script>

<style scoped>

</style>
