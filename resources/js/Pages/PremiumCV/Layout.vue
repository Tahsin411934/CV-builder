<template>
  <div class="row justify-content-center ">
    <div class="col-2 bg1-custom">
      
      <Timeline :templateId="templateId" />

    </div>
    <div class="col-10">
      <div class="w-100" style="margin: auto">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import Timeline from './Timeline.vue';

export default {
  components: { Timeline },
  data() {
    return {
      templateId: null, // Initialize templateId
    };
  },
  computed: {
  templateId() {
    return this.$route.params.id; // Directly get it from route params
  }
}

};
</script>

<style scoped></style>