<template>
  <div class="row justify-content-center  w-100 ">
    <div class="col-2 bg1-custom">
      <timeline />
    </div>
    <div class="col-10">
      <div class="w-100" style=" margin:auto">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import Timeline from "../../components/Timeline.vue";
export default {
  components: { Timeline },
};
</script>

<style scoped></style>
