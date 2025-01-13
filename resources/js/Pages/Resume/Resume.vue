<template>
  <div class="row justify-content-center align-align-items-center">
    <div class="col-3">
      <timeline />
    </div>
    <div class="col-9">
      <div style="width: 100%; margin:auto">
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
