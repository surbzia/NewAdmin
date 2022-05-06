<template>
  <div v-if="loggedIn">
    <v-app-bar app color="primary" dark>
      <div class="d-flex align-center">
        <!-- <v-img
          :src="require('./assets/logo.png')"
        /> -->
      </div>

      <v-spacer></v-spacer>
      <v-btn :to="{ name: 'auth.notifications' }" text>
        <v-badge
          :content="user.notification_count"
          :value="user.notification_count"
          color="green"
          overlap
        >
          <v-icon >
            mdi-minus-circle-outline
          </v-icon>
        </v-badge>
      </v-btn>
      <v-btn :to="{ name: 'auth.dashboard' }" text>
        <span class="mr-2">Dashboard</span>
        <v-icon>mdi-account-circle</v-icon>
      </v-btn>
      <v-btn @click="logoutauthparent" text>
        <span class="mr-2">Logout</span>
        <v-icon>mdi-open-in-new</v-icon>
      </v-btn>
      <v-menu
        bottom
        left
        transition="slide-y-transition"
        open-on-hover
        :close-on-content-click="false"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn dark icon offset-y v-bind="attrs" v-on="on">
            <v-icon>mdi-anchor</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item
            v-for="(addShortCut, addShortCutk) in addShortCuts"
            :key="addShortCutk"
            link
            :to="{ name: addShortCut.to }"
            v-if="permissions.indexOf(addShortCut.permission_id)>=0"
          >
            <v-list-item-title
              ><v-icon>mdi-plus</v-icon>{{addShortCut.name}}</v-list-item-title
            >
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
    <v-hover v-slot="{ hover }">
    <v-navigation-drawer
      v-model="drawer"
      permanent
      absolute
      class=""
      mini-variant
      v-if="!showsidebar"
      dark
      :color="!hover?'primary':undefined"
    >
      <v-system-bar></v-system-bar>
      <v-system-bar></v-system-bar>
      <v-system-bar></v-system-bar>
      <v-list-item class="px-2" link :to="{ name: 'auth.profile' }">
        <v-list-item-avatar>
          <v-img :src="user.image_url"></v-img>
        </v-list-item-avatar>

        <v-list-item-title>{{ user.name }}</v-list-item-title>

        <v-btn icon @click.stop="mini = !mini">
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>
      <v-divider></v-divider>
      <v-list dense nav>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(61)>=0?'auth.permissions.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-alpha-p'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Permission</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(62)>=0">
              <v-list-item exact link :to="{ name: 'auth.permissions.add' }">
                <v-list-item-title>Add Permission</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(56)>=0?'auth.roles.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-shape-circle-plus'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Role</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(57)>=0">
              <v-list-item exact link :to="{ name: 'auth.roles.add' }">
                <v-list-item-title>Add Role</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(1)>=0?'auth.users.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-account-multiple-plus-outline'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Users</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(2)>=0">
              <v-list-item exact link :to="{ name: 'auth.users.add' }">
                <v-list-item-title>Add User</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(93)>=0?'auth.products.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-chart-ppf'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Products</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(95)>=0">
              <v-list-item exact link :to="{ name: 'auth.products.add' }">
                <v-list-item-title>Add Product</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(113)>=0?'auth.coupons.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-ticket-percent-outline'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Coupons</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(114)>=0">
              <v-list-item exact link :to="{ name: 'auth.coupons.add' }">
                <v-list-item-title>Add Coupon</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(133)>=0?'auth.categories.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-tag-heart-outline'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Category</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(135)>=0">
              <v-list-item exact link :to="{ name: 'auth.categories.add' }">
                <v-list-item-title>Add Category</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(138)>=0?'auth.brands.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-watermark'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Brand</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(140)>=0">
              <v-list-item exact link :to="{ name: 'auth.brands.add' }">
                <v-list-item-title>Add Brand</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(153)>=0?'auth.banners.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-image-album'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Banners</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(155)>=0">
              <v-list-item exact link :to="{ name: 'auth.banners.add' }">
                <v-list-item-title>Add Banner</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(163)>=0?'auth.countries.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-flag'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Countries</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(165)>=0">
              <v-list-item exact link :to="{ name: 'auth.countries.add' }">
                <v-list-item-title>Add Country</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(168)>=0?'auth.states.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-abacus'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>States</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list v-if="permissions.indexOf(170)>=0">
              <v-list-item exact link :to="{ name: 'auth.states.add' }">
                <v-list-item-title>Add State</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(143)>=0?'auth.product_quotes.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hovers
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-format-quote-open-outline'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Product Quotes</v-list-item-title>
              </v-list-item-content>
            </template>
          </v-menu>
        </v-list-item>
        <!-- <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(158)>=0?'auth.productscsv':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-file-delimited-outline'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Upload Product CSV</v-list-item-title>
              </v-list-item-content>
            </template>
          </v-menu>
        </v-list-item> -->
        <v-list-item
          class="pa-0"
          link
          :to="{ name: (permissions.indexOf(159)>=0?'auth.orders.listing':'auth.dashboard') }"
        >
          <v-menu
            open-on-hover
            offset-x
            style="max-width: 600px"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-list-item-icon
                color="primary"
                dark
                class="d-block"
                style="width: 100%; text-align: center"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon v-text="'mdi-dolly'"></v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Orders Listing</v-list-item-title>
              </v-list-item-content>
            </template>
          </v-menu>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    </v-hover>
  </div>
</template>
<script>
export default {
  name: "sidebar",
  components: {},
  props: ["showsidebar"],
  data: () => ({
    drawer: false,
    mini: true,
    addShortCuts: [
      {
        name: 'Role',
        to:"auth.roles.add",
        permission_id: 57,
      },
      {
        name: 'Permission',
        to:"auth.permissions.add",
        permission_id: 62,
      },
      {
        name: 'User',
        to:"auth.users.add",
        permission_id: 2,
      },
      {
        name: 'Product',
        to: 'auth.products.add',
        permission_id: 95,
      },
      {
        name: 'Coupon',
        to: 'auth.coupons.add',
        permission_id: 114,
      },
      {
        name: 'Category',
        to: 'auth.categories.add',
        permission_id: 133,
      },
      {
        name: 'Brand',
        to: 'auth.brands.add',
        permission_id: 140,
      },
    //   {
    //     name: 'Upload Product CSV',
    //     to: 'auth.productscsv',
    //     permission_id: 158,
    //   },
      {
        name: 'Country',
        to: 'auth.countries.add',
        permission_id: 165,
      },
      {
        name: 'State',
        to: 'auth.states.add',
        permission_id: 170,
      },
      {
        name: 'Order',
        to: 'auth.orders.add',
        permission_id: 178,
      },
    ]
  }),
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
};
</script>
