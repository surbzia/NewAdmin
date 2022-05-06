<template>
  <div>
    <div>
      <aside
        class="main-sidebar sidebar-light-primary elevation-4"
        v-if="loggedIn"
      >
        <div class="sidebar" style="overflow-y: auto">
          <nav class="mt-2">
            <ul
              class="nav nav-pills nav-sidebar flex-column"
              data-widget="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <router-link :to="'/'" class="nav-link">
                  <i class="nav-icon fas fa-table"></i>
                  <p>DASHBOARD</p>
                </router-link>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-user"></i>

                  <p>
                    User Management
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <router-link
                      :to="{ name: 'auth.roles.listing' }"
                      class="nav-link"
                    >
                      <i class="fa fa-dice nav-icon" aria-hidden="true"></i>
                      <p>Roles</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link
                      :to="{ name: 'auth.permissions.listing' }"
                      class="nav-link"
                    >
                      <i class="fa fa-lock nav-icon" aria-hidden="true"></i>
                      <p>Permissions</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link
                      :to="{ name: 'auth.users.listing' }"
                      class="nav-link"
                    >
                      <i class="nav-icon fas fa-user"></i>
                      <p>Users</p>
                    </router-link>
                  </li>
                </ul>
              </li>

              <!-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Tables
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a
                                        href="pages/tables/simple.html"
                                        class="nav-link"
                                    >
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Simple Tables</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="pages/tables/data.html"
                                        class="nav-link"
                                    >
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>DataTables</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="pages/tables/jsgrid.html"
                                        class="nav-link"
                                    >
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>jsGrid</p>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
            </ul>
          </nav>
        </div>
      </aside>
      <aside class="main-sidebar sidebar-dark-primary elevation-4" v-else>
        <h1
          class="text-white"
          style="    text-align: center;
    vertical-align: middle;
    line-height: 100vh;
}"
        >
          LOGIN
        </h1>
      </aside>
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