<template>
  <div class="d-inline">
    <v-chip text-color="white" :color="statuses[order_status].color" > {{statuses[order_status].name}} </v-chip>
  </div>
</template>
<script>
export default {
  props: {
    order_status: { 
      type: Number,
      default: 1,
    },
  },
  data(){
      return{
          //1 = pending, 2 = processing, 3 = holded, 4 = canceled, 5 = complete/delivered
          statuses:{
              1: {color: 'primary', name:'Pending'},
              2: {color: 'orange', name:'Processing'},
              3: {color: 'blue', name:'Holded'},
              4: {color: 'red', name:'Canceled'},
              5: {color: 'green', name:'Completed/Delivered'},
          }
      }
  }
};
</script>