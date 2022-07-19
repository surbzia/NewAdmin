<template>
  <div v-if="loggedIn">
    <div class="left-side-bar">
      <div
        class="brand-logo"
        style="
          width: 100%;
          background-color: white;
          border-right: 1px solid #e5e4e4;
        "
      >
        <a href="index.html">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbyLDVdHqZvNoDst3LmmbgMntpMybefEZNsQ&usqp=CAU"
            alt=""
            class="light-logo"
            style="width: 100px; margin-left: 16px"
          />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
          <i class="ion-close-round"></i>
        </div>
      </div>
      <div class="menu-block customscroll">
        <div class="sidebar-menu">
          <ul id="accordion-menu">
            <li>
              <router-link
                :to="'/admin/dashboard'"
                class="dropdown-toggle no-arrow"
              >
                <span class="micon dw dw-analytics-3"></span
                ><span class="mtext">Dashboard</span>
              </router-link>
            </li>

            <li class="dropdown">
              <a class="dropdown-toggle" data-option="on">
                <span class="micon dw dw-house-1"></span
                ><span class="mtext">User Management</span>
              </a>
              <ul class="submenu">
                <li>
                  <router-link :to="'/admin/permissions/'"
                    >Permissions</router-link
                  >
                </li>
                <li>
                  <router-link :to="'/admin/roles/'"
                    >Roles</router-link
                  >
                </li>
                <li>
                  <router-link :to="'/admin/dashboard'"
                    >User</router-link
                  >
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    user() {
      return this.$store.getters.loggedInUser;
    },
    loggedIn() {
      return this.$store.getters.loggedIn;
    },
    permissions() {
      return this.$store.getters.getPermissions;
    },
  },
};
</script>
