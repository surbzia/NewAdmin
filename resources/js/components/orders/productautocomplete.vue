<template>
  <v-autocomplete
    v-model="autocomplete.item"
    :items="autocomplete.entries"
    :loading="autocomplete.isLoading"
    :search-input.sync="autocomplete.search"
    color="white"
    hide-no-data
    hide-selected
    item-text="sku"
    item-value="id"
    label="Product"
    placeholder="Start typing to Search"
    prepend-icon="mdi-database-search"
    return-object
  ></v-autocomplete>
</template>
<script>
import defaultservice from "@services/auth/default";
const productservice = new defaultservice('products')
export default {
    props:{
        index:{
            type: Number,
            default: 0,
        }
    },
    data(){
        return{
            autocomplete:{
                isLoading: false,
                model: '',
                search: '',
                entries: [],
                item: {},
            }
        }
    },
    watch:{
        'autocomplete.search': async function(){
            // if (this.autocomplete.items.length > 0) return
            if (this.autocomplete.isLoading) return
            if (!this.autocomplete.search) return
            this.autocomplete.isLoading = true
            await productservice.getlist('?search='+this.autocomplete.search+'&perpage=20&restrict=true').then(e=>{
                this.autocomplete.entries = e.data
            })
            this.autocomplete.isLoading = false
        },
        'autocomplete.item': function(){
            this.$emit('product_select',this.index, this.autocomplete.item)
        }
    }
}
</script>