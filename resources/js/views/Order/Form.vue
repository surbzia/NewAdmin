<template>
  <div>
    <v-breadcrumbs :items="bread">
      <template v-slot:divider>
        <v-icon>mdi-forward</v-icon>
      </template></v-breadcrumbs
    >
</v-breadcrumbs>
<v-row no-gutters  class="grey lighten-5 pa-10 rounded elevation-10">
<v-col
cols="12"
sm="12"
>
<v-form
ref="form"
v-model="loading"
lazy-validation
>

<v-row>
<v-col
  cols="4"
  sm="4"
  class="pb-0"
>
  <v-text-field
    v-model="form.shipping_first_name"
    :rules="[rules.required]"
    :error-messages="errors.shipping_first_name"
    label="Shipping First Name"
  ></v-text-field>
</v-col>

<v-col
  cols="4"
  sm="4"
  class="pb-0"
>
<v-text-field
    v-model="form.shipping_last_name"
    :rules="[rules.required]"
    :error-messages="errors.shipping_last_name"
    label="Shipping Last Name"
  ></v-text-field>
</v-col>

<v-col
  cols="4"
  sm="4"
  class="pb-0"
>
<v-text-field
    v-model="form.shipping_email"
    :rules="[rules.required]"
    :error-messages="errors.shipping_email"
    label="Shipping Email"
  ></v-text-field>
</v-col>

<v-col
  cols="3"
  sm="3"
  class="pb-0"
>
<v-select
    v-model="form.shipping_country"
    :error-messages="errors.shipping_country"
    :items="countries"
    label="Country"
    item-text="name"
    item-value="id"
></v-select>
</v-col>

<v-col
  cols="3"
  sm="3"
  class="pb-0"
>
<v-select
    v-model="form.shipping_state"
    :error-messages="errors.shipping_state"
    :items="states"
    label="State"
    item-text="name"
    item-value="id"
></v-select>
</v-col>

<v-col
  cols="3"
  sm="3"
  class="pb-0"
>
<v-text-field
    v-model="form.shipping_city"
    :rules="[rules.required]"
    :error-messages="errors.shipping_city"
    label="City"
  ></v-text-field>
</v-col>

<v-col
  cols="3"
  sm="3"
  class="pb-0"
>
<v-text-field
    v-model="form.shipping_zip"
    :rules="[rules.required]"
    :error-messages="errors.shipping_zip"
    label="Shipping Zip Code"
  ></v-text-field>
</v-col>

<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
<v-text-field
    v-model="form.shipping_company"
    :error-messages="errors.shipping_company"
    label="Shipping Company"
  ></v-text-field>
</v-col>

<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
<v-text-field
    v-model="form.shipping_phone"
    :rules="[rules.required]"
    :error-messages="errors.shipping_phone"
    label="Shipping Phone"
  ></v-text-field>
</v-col>

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-text-field
    v-model="form.shipping_address"
    :rules="[rules.required]"
    :error-messages="errors.shipping_address"
    label="Shipping Address"
  ></v-text-field>
</v-col>

<v-col cols="12" sm="12" class="pb-0">
  <v-checkbox
    v-model="same_as_shipping"
    label="Same as Shipping?"
  ></v-checkbox>
</v-col>

<v-col v-if="!same_as_shipping" cols="12" sm="12" class="pb-0">
<v-row>
<v-col
  cols="4"
  sm="4"
  class="pb-0"
>
  <v-text-field
    v-model="form.billing_first_name"
    :rules="[rules.required]"
    :error-messages="errors.billing_first_name"
    label="Billing First Name"
  ></v-text-field>
</v-col>

<v-col
  cols="4"
  sm="4"
  class="pb-0"
>
<v-text-field
    v-model="form.billing_last_name"
    :rules="[rules.required]"
    :error-messages="errors.billing_last_name"
    label="Billing Last Name"
  ></v-text-field>
</v-col>

<v-col
  cols="4"
  sm="4"
  class="pb-0"
>
<v-text-field
    v-model="form.billing_email"
    :rules="[rules.required]"
    :error-messages="errors.billing_email"
    label="Billing Email"
  ></v-text-field>
</v-col>

<v-col
  cols="3"
  sm="3"
  class="pb-0"
>
<v-select
    v-model="form.billing_country"
    :error-messages="errors.billing_country"
    :items="countries"
    label="Country"
    item-text="name"
    item-value="id"
></v-select>
</v-col>

<v-col
  cols="3"
  sm="3"
  class="pb-0"
>
<v-select
    v-model="form.billing_state"
    :error-messages="errors.billing_state"
    :items="states"
    label="State"
    item-text="name"
    item-value="id"
></v-select>
</v-col>

<v-col
  cols="3"
  sm="3"
  class="pb-0"
>
<v-text-field
  v-model="form.billing_city"
  :rules="[rules.required]"
  :error-messages="errors.billing_city"
  label="City"
></v-text-field>
</v-col>

<v-col
  cols="3"
  sm="3"
  class="pb-0"
>
<v-text-field
    v-model="form.billing_zipcode"
    :rules="[rules.required]"
    :error-messages="errors.billing_zipcode"
    label="Billing Zip Code"
  ></v-text-field>
</v-col>

<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
<v-text-field
    v-model="form.billing_company"
    :error-messages="errors.billing_company"
    label="Billing Company"
  ></v-text-field>
</v-col>

<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
<v-text-field
    v-model="form.billing_phone"
    :rules="[rules.required]"
    :error-messages="errors.billing_phone"
    label="Billing Phone"
  ></v-text-field>
</v-col>

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-text-field
    v-model="form.billing_address"
    :rules="[rules.required]"
    :error-messages="errors.billing_address"
    label="Billing Address"
  ></v-text-field>
</v-col>
</v-row>
</v-col>
<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-simple-table>
  <template v-slot:default>
    <thead>
      <tr>
        <th class="text-left">
          Product
        </th>
        <th class="text-left">
          Quantity
        </th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(v,k) in items"
        :key="k"
      >
        <td>
          <div v-if="v.item_id>0">{{v.item.sku}}</div>
          <productautocomplete :index="k" @product_select="selectProductAutoComplete" />
        </td>
        <td><v-text-field type="number" v-model.number="v.qty" :rules="[rules.required]"></v-text-field></td>
        <td><v-btn
          icon
          color="red"
          @click="items.splice(k,1)"
        >
          <v-icon>mdi-content-cut</v-icon>
        </v-btn></td>
      </tr>
    </tbody>
  </template>
</v-simple-table>
</v-col>
 <v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-btn
    color="primary mb-2"
    elevation="1"
    large
    raised
    @click="additem"
  >Add Item</v-btn>
<v-divider></v-divider>
</v-col>
<v-col
  cols="4"
  sm="4"
  offset="8"
  class="pb-0"
>
<v-card>
    <v-toolbar
      flat
      color="blue-grey"
      dark
    >
      <v-toolbar-title>Total</v-toolbar-title>
    </v-toolbar>

    <v-card-text>
      <v-text-field
        filled
        label="Sub Total"
        readonly
        :value="order_subtotal"
      ></v-text-field>
      <v-text-field
        filled
        label="Discount"
        type="number"
        step="any"
        v-model.number="order_discount"
      ></v-text-field>
      <v-text-field
        filled
        label="Tax%"
        type="number"
        step="any"
        readonly
        persistent-hint
        :hint="tax_amount.toString()"
        v-model.number="tax_percent"
      ></v-text-field>
      <v-text-field
        filled
        label="Total"
        readonly
        :value="order_total_after_tax"
      ></v-text-field>
    </v-card-text>
  </v-card>
</v-col>

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-btn
    color="secondary"
    elevation="1"
    large
    raised
    @click="addpermission"
    :loading="btnloading"
    :disabled="btnloading"
  >{{form.id>0?'Update':'Create Order'}}</v-btn>
</v-col>

</v-row>

</v-form>
</v-col>
</v-row>
  </div>
</template>

<script>
import defaultservice from "@services/auth/default";
const service = new defaultservice('orders')
const countryservice = new defaultservice('countries')
const stateservice = new defaultservice('states')
const citieservice = new defaultservice('cities')
const exemptionservice = new defaultservice('user-exemptions')
import productautocomplete from "@/components/orders/productautocomplete.vue";
export default {
  components:{
    productautocomplete,
  },
  name: "auth.orders.add",
  watch:{
    'form': {
      handler (){
        this.checkfortax()
      },
      deep: true,
    },
    'form.shipping_country': function(){
      stateservice.getlist('?country_id='+this.form.shipping_country).then(e=>{
        this.cities = []
        this.form.shipping_state = 0
        this.states = e.data
      })
    },
    'form.shipping_state': function(){
      
    },
    'form.billing_country': function(){
      stateservice.getlist('?country_id='+this.form.billing_country).then(e=>{
        this.cities = []
        if(this.same_as_shipping==true){
          this.form.billing_state = this.form.shipping_state
          this.form.billing_city = this.form.shipping_city
        }else{
          this.form.billing_state = 0
          this.form.billing_city = ''
        }
        this.billing_states = e.data
      })
    },
    'form.billing_state': function(){
      
    },
    'same_as_shipping': function(){
      if(this.same_as_shipping==true){
        this.form.billing_first_name = this.form.shipping_first_name
        this.form.billing_last_name = this.form.shipping_last_name
        this.form.billing_email = this.form.shipping_email
        this.form.billing_address = this.form.shipping_address
        this.form.billing_phone = this.form.shipping_phone
        this.form.billing_zipcode = this.form.shipping_zip
        this.form.billing_company = this.form.shipping_company
        this.form.billing_country = this.form.shipping_country
        this.form.billing_city = this.form.shipping_city
        this.form.billing_state = this.form.shipping_state
      }else{
        this.form.billing_first_name = ''
        this.form.billing_last_name = ''
        this.form.billing_email = ''
        this.form.billing_address = ''
        this.form.billing_phone = ''
        this.form.billing_zipcode = ''
        this.form.billing_company = ''
        this.form.billing_country = ''
        this.form.billing_city = ''
        this.form.billing_state = ''
      }
    },
  },
  async mounted(){
    countryservice.getlist('').then(e=>{
      this.countries = e.data
      this.billing_countries = e.data
    })
    setInterval(()=>{
      if(this.same_as_shipping==true){
        this.form.billing_first_name = this.form.shipping_first_name
        this.form.billing_last_name = this.form.shipping_last_name
        this.form.billing_email = this.form.shipping_email
        this.form.billing_address = this.form.shipping_address
        this.form.billing_phone = this.form.shipping_phone
        this.form.billing_zipcode = this.form.shipping_zip
        this.form.billing_company = this.form.shipping_company
        this.form.billing_country = this.form.shipping_country
        this.form.billing_city = this.form.shipping_city
        this.form.billing_state = this.form.shipping_state
      }
    },300)
    if(this.$route.params.id){
        var res = await service.get(this.form.id)
        this.form = {
            shipping_email: res.shipping_email,
            shipping_first_name: res.shipping_first_name,
            shipping_last_name: res.shipping_last_name,
            shipping_city: res.shipping_city,
            shipping_country: res.shipping_country,
            shipping_state: res.shipping_state,
            shipping_zip: res.shipping_zip,
            shipping_company: res.shipping_company,
            shipping_phone: res.shipping_phone,
            shipping_notes: res.shipping_notes,
            shipping_address: res.shipping_address,
            billing_email: res.billing_email,
            billing_first_name: res.billing_first_name,
            billing_last_name: res.billing_last_name,
            billing_city: res.billing_city,
            billing_country: res.billing_country,
            billing_state: res.billing_state,
            billing_zipcode: res.billing_zipcode,
            billing_company: res.billing_company,
            billing_phone: res.billing_phone,
            billing_address: res.billing_address,
            id: this.$route.params.id,
        }
        this.bread.push({
          text: "Edit",
          to: { name: "auth.orders.edit", params: {id: this.$route.params.id} },
          disabled: false,
          exact: true,
        })
    }else{
        this.bread.push({
          text: "Add",
          to: { name: "auth.orders.add"},
          disabled: false,
          exact: true,
        })
    }
  },
  methods: {
    checkfortax(){
      this.tax_percent = 0
      if(parseInt(this.form.billing_state)>0){
        clearInterval(this.taxcalls);
        this.taxcalls = setInterval(()=>{
          clearInterval(this.taxcalls);
          exemptionservice.getlist('?user_email='+this.form.billing_email+'&state_id='+this.form.billing_state).then(e=>{
            if(e.data.length==0){
              stateservice.get(this.form.billing_state).then(e=>{
                this.tax_percent = e.tax_percent
              })
            }
          })
        },500)
      }
    },
    additem(){
      this.items.push({
        item_id: 0,
        qty: 1,
        item: {},
      })
    },
    selectProductAutoComplete(index, obj){
      this.items[index].item = obj
      this.items[index].item_id = obj.id
    },
    resetError(){
        this.errors = {
          shipping_email: [],
          shipping_notes: [],
          shipping_first_name: [],
          shipping_last_name: [],
          shipping_address: [],
          shipping_city: [],
          shipping_country: [],
          shipping_company: [],
          shipping_state: [],
          shipping_zip: [],
          shipping_phone: [],
          billing_email: [],
          billing_first_name: [],
          billing_last_name: [],
          billing_city: [],
          billing_country: [],
          billing_state: [],
          billing_zipcode: [],
          billing_company: [],
          billing_phone: [],
          billing_address: [],
      }
    },
    addpermission: async function () {
        this.resetError()
      if (this.$refs.form.validate()) {
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("shipping_email", this.form.shipping_email)
        formdata.append("shipping_notes", this.form.shipping_notes)
        formdata.append("shipping_first_name", this.form.shipping_first_name)
        formdata.append("shipping_last_name", this.form.shipping_last_name)
        formdata.append("shipping_address", this.form.shipping_address)
        formdata.append("shipping_city", this.form.shipping_city)
        formdata.append("shipping_country", this.form.shipping_country)
        formdata.append("shipping_company", this.form.shipping_company)
        formdata.append("shipping_state", this.form.shipping_state)
        formdata.append("shipping_zip", this.form.shipping_zip)
        formdata.append("shipping_phone", this.form.shipping_phone)
        formdata.append("billing_email", this.form.billing_email)
        formdata.append("billing_first_name", this.form.billing_first_name)
        formdata.append("billing_last_name", this.form.billing_last_name)
        formdata.append("billing_city", this.form.billing_city)
        formdata.append("billing_country", this.form.billing_country)
        formdata.append("billing_state", this.form.billing_state)
        formdata.append("billing_zipcode", this.form.billing_zipcode)
        formdata.append("billing_company", this.form.billing_company)
        formdata.append("billing_phone", this.form.billing_phone)
        formdata.append("billing_address", this.form.billing_address)
        formdata.append("discount_amount", this.order_discount)
        formdata.append("tax_percent", this.tax_percent)        
        for(let i = 0; i < this.items.length; i++){
          formdata.append("items["+i+"][quantity]", this.items[i].qty)
          formdata.append("items["+i+"][id]", this.items[i].item_id)
        }
        this.btnloading = false;
        if(this.form.id>0){
            var res = await service.update(formdata, this.form.id)
        }else{
            var res = await service.create(formdata)
        }
        if(!res.status){
            if(res.data.shipping_email){
              this.errors.shipping_email = res.data.shipping_email
            }
            if(res.data.shipping_notes){
              this.errors.shipping_notes = res.data.shipping_notes
            }
            if(res.data.shipping_first_name){
              this.errors.shipping_first_name = res.data.shipping_first_name
            }
            if(res.data.shipping_last_name){
              this.errors.shipping_last_name = res.data.shipping_last_name
            }
            if(res.data.shipping_address){
              this.errors.shipping_address = res.data.shipping_address
            }
            if(res.data.shipping_city){
              this.errors.shipping_city = res.data.shipping_city
            }
            if(res.data.shipping_country){
              this.errors.shipping_country = res.data.shipping_country
            }
            if(res.data.shipping_company){
              this.errors.shipping_company = res.data.shipping_company
            }
            if(res.data.shipping_state){
              this.errors.shipping_state = res.data.shipping_state
            }
            if(res.data.shipping_zip){
              this.errors.shipping_zip = res.data.shipping_zip
            }
            if(res.data.shipping_phone){
              this.errors.shipping_phone = res.data.shipping_phone
            }
            if(res.data.billing_email){
              this.errors.billing_email = res.data.billing_email
            }
            if(res.data.billing_first_name){
              this.errors.billing_first_name = res.data.billing_first_name
            }
            if(res.data.billing_last_name){
              this.errors.billing_last_name = res.data.billing_last_name
            }
            if(res.data.billing_city){
              this.errors.billing_city = res.data.billing_city
            }
            if(res.data.billing_country){
              this.errors.billing_country = res.data.billing_country
            }
            if(res.data.billing_state){
              this.errors.billing_state = res.data.billing_state
            }
            if(res.data.billing_zipcode){
              this.errors.billing_zipcode = res.data.billing_zipcode
            }
            if(res.data.billing_company){
              this.errors.billing_company = res.data.billing_company
            }
            if(res.data.billing_phone){
              this.errors.billing_phone = res.data.billing_phone
            }
            if(res.data.billing_address){
              this.errors.billing_address = res.data.billing_address
            }
            //errors here
        }else{
            //suuccess here
            this.$router.push({ name: "auth.orders.listing" });
        }
      }
    },
  },
  data() {
    return {
      countries: [],
      states: [],
      cities: [],
      billing_countries: [],
      billing_states: [],
      billing_cities: [],
      same_as_shipping: true,
      order_discount: 0,
      tax_percent: 0,
      taxcalls: undefined,
      form:{
          id: (this.$route.params.id?this.$route.params.id:0),
          shipping_email: '',
          shipping_notes: '',
          shipping_first_name: '',
          shipping_last_name: '',
          shipping_address: '',
          shipping_city: '',
          shipping_country: '',
          shipping_company: '',
          shipping_state: '',
          shipping_zip: '',
          shipping_phone: '',
          billing_email: '',
          billing_first_name: '',
          billing_last_name: '',
          billing_city: '',
          billing_country: '',
          billing_state: '',
          billing_zipcode: '',
          billing_company: '',
          billing_phone: '',
          billing_address: '',
      },
      errors: {
        shipping_email: [],
        shipping_notes: [],
        shipping_first_name: [],
        shipping_last_name: [],
        shipping_address: [],
        shipping_city: [],
        shipping_country: [],
        shipping_company: [],
        shipping_state: [],
        shipping_zip: [],
        shipping_phone: [],
        billing_email: [],
        billing_first_name: [],
        billing_last_name: [],
        billing_city: [],
        billing_country: [],
        billing_state: [],
        billing_zipcode: [],
        billing_company: [],
        billing_phone: [],
        billing_address: [],
      },
      items: [],
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "Order",
          to: { name: "auth.orders.listing" },
          disabled: false,
          exact: true,
        }
      ],
      loading: false,
      btnloading: false,
      rules: {
        required: (value) => !!value || "Required.",
      },
    };
  },
  computed:{
    user() {
        return this.$store.getters.loggedInUser;
    },
    order_subtotal(){
      let sub_total = 0
      for(let i = 0; i < this.items.length; i++){
        if(this.items[i].item_id>0){
          sub_total+=(this.items[i].item.actual_price*this.items[i].qty)
        }
      }
      return sub_total
    },
    order_total(){
      let total = 0
      if(this.items.length>0){
        total = (this.order_subtotal-this.order_discount)
      }
      return total
    },
    tax_amount(){
      let tax_amount = (this.order_total/100)*this.tax_percent
      return tax_amount;
    },
    order_total_after_tax(){
      return this.order_total+this.tax_amount
    }
  }
};
</script>
