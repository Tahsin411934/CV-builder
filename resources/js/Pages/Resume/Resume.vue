<template>
  <div class="row">
    <div class="col-3">
      <timeline />
    </div>
    <div class="col-9">
      
<router-view></router-view>
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
