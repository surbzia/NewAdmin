<template>
  <div>
    <topbarVue></topbarVue>
    <left_nav></left_nav>
    <div class="">
      <div class="mb-15 ml-0">
            <div class="main-container">
    <div class="card-box pd-20 mb-30">
        <router-view />
      </div>
      </div>
      </div>
    </div>
  </div>
</template>

<script>
import topbarVue from "../components/sidebars/topbar.vue";
import left_nav from "../components/sidebars/left_nav.vue";
export default {
  name: "AdminLayout",
  components: {
    left_nav,
    topbarVue,
  },
};
</script>

<style >
</style>
