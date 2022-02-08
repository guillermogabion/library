<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title>
        Books
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addBook"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :page="page"
        :pageCount="numberOfPages"
        :headers="headers"
        :items="products"
        :options.sync="options"
        :server-items-length="total"
        :items-per-page="options.itemsPerPage"
        @update:options="initialize"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.is_refill="{ item }">
          <!-- <v-switch
            color="light-blue"
            v-model="item.is_refill"
            @click="changeRefillState(item)"
          ></v-switch> -->
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            class="mr-2"
            @click="editBook(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteProduct(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <AddBookForm :form="bookForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveProduct()" />

</div>
</template>
<script>
  import AddBookForm from '../../components/adminForms/Book.vue'
  export default {
    components: {
      AddBookForm
    },
    data() {
      return {
        page: 0,
        total: 0,
        numberOfPages: 0,
        products: [],
        loading: true,
        options: {
          itemsPerPage: 10
        },
        footerProps :{
          "items-per-page-options" : [5,10,15, 30, ]
        },
        headers: [
          { text: "Book Title", value: "title" },
          { text: "Author", value: "author" },
          { text: "Count", value: "count" },
          { text: "Status", value: "status" },
          { text: "Actions", value: "actions", sortable: false, },
        ],
        addition_edition_dailog: false,
        bookForm: {
          id:null,
          title: '',
          author: '',
          count: 0,
          status: null,
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
      };
  },
  //this one will populate new data set when user changes current page. 
  watch: {
    options: {
      handler(val) {
        this.initialize() 
      },
    },
    deep: true,
  },
  methods: {
    //Reading data from API method. 
    initialize() {
        this.bookForm = {
          id:null,
          title: '',
          author: '',
          count: 0,
          status: null,
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        const { page, itemsPerPage } = this.options;
        let params = { 
          page: page,
          per_page: itemsPerPage
        } 
        this.$admin.get('/product/all', { params })
          .then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.products = data.data;
            this.page = data.page;
            this.total = data.total;
            this.numberOfPages = data.last_page;
          });
    },
    
    // changeRefillState(product){
    //   this.bookForm = {
    //     id: product.id,
    //     name: product.name ,
    //     title:  product.description ,
    //     author:  product.description ,
    //     count: 0roduct.description ,
    //     status: null.is_refill ,
    //     image: '/storage/'+product.image 
    //   }

    //   this.saveProduct()
    // },
    addBook(){
      this.bookForm = {
        id:null,
        title: '',
        author: '',
        count: 0,
        status: null,
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editBook(product){
      this.bookForm = {
        id: product.id,
        name: product.name ,
        title:  product.description ,
        author:  product.description ,
        count: product.description ,
        status: null.is_refill ,
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveProduct(){
      if(this.bookForm.id){
        this.$admin.put('/product/update/'+this.bookForm.id,this.bookForm).then(({data}) => {
          this.initialize()
        })
      }
      else{
        this.$admin.post('/product/create',this.bookForm).then(({data}) =>{
      
          this.initialize()
        })
      }
    },
    deleteProduct(product){
      this.$admin.delete('/product/delete/'+ product.id).then(({data}) => {
        this.initialize() 
      })
    }
  },
  
  //this will trigger in the onReady State
  mounted() {
    this.initialize();
  },
  }
</script>