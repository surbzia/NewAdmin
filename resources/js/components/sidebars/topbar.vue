<template>
    <div  v-if="loggedIn">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        data-widget="pushmenu"
                        href="#"
                        role="button"
                        ><i class="fas fa-bars"></i
                    ></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                 <i class="fas fa-user-circle" style="    font-size: 35px;
    margin-top: -5px;"></i>
                        <!-- <span class="badge badge-warning navbar-badge">15</span> -->
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                    >
                                          
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a
                            href="javascript:;"
                             @click="logoutauthparent"
                            class="dropdown-item dropdown-footer text-danger"
                            >Logout</a
                        >
                    </div>
                </li>
            </ul>
        </nav>
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
