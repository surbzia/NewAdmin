<template>
    <div class="header shadow" v-if="loggedIn">
        <div class="header-left">
            <span class="menu-icon icon-copy ti-menu ml-3"></span>
        </div>
        <div class="header-right pr-20">
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle mt-xl-1" href="#" role="button" data-toggle="dropdown"
                        style="padding-top: 15px;">
                        <span class="font-10"> {{user.name}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list shadow-lg">
                        <!-- <a class="dropdown-item" @click="logoutauthparent" href="#"><i class="dw dw-logout"></i> Log
                            Out</a> -->
                        <button class="dropdown-item" @click="logoutauthparent"><i class="dw dw-logout"></i> Log
                            Out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
      props: ["showsidebar"],
      methods: {
    logoutauthparent() {
      this.$store.commit("setLoginStatus", false);
      this.$store.commit("setAuthToken", "");
      this.$store.commit("setloggedInUser", {});
      this.$router.push({ name: "auth.login" });
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
