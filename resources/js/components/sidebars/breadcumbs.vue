<template>
    <div v-if="loggedIn">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">{{data.step1}}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/">Home</router-link>
                            </li>
                            <li class="breadcrumb-item">{{data.step1}}</li>
                            <li class="breadcrumb-item active">{{data.step2}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
     props: {
      data: {
      default: {},
      type: Object,
    },
  },
        computed: {
    user() {
      return this.$store.getters.loggedInUser;
    },
    loggedIn() {
      return this.$store.getters.loggedIn;
    },
    permissions(){
      return this.$store.getters.getPermissions
    }
  },
}
</script>
