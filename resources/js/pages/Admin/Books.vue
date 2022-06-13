<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        List of Books
        <v-spacer></v-spacer>
        <v-icon
          large
          @click="addBook"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-card-title>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="books"
        :loading="loading"
        :search="search"
        class="elevation-1"
      >
        <template v-slot:item.status ="{ item }">
            {{item.status == 1 ? 'Available' : 'Unavailable'}}
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
    <BookForm :form="bookForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveBook()" />

</div>
</template>
<script>
  import BookForm from '../../components/adminForms/Book.vue'
  export default {
    components: {
      BookForm
    },
    data() {
      return {
        search: '',
        books: [],
        loading: true,
        footerProps :{
          "items-per-page-options" : [5,10,15, 30, ]
        },
        headers: [
          {
            text: 'ID',
            align: 'center',
            sortable: false,
            value: 'id',
          },
          { text: "Book Name", value: "book_title", align: 'center'},
          { text: "Author", value: "author", align: 'center' },
          { text: "Book Type", value: "book_type", align: 'center' },
          { text: "Available Books", value: "available" , align: 'center'},
          { text: "Total Books", value: "total", align: 'center' },
          { text: "Status", value: "status", align: 'center' },
          { text: "Actions", value: "actions", sortable: false,align: 'center' },
        ],
        addition_edition_dailog: false,
        bookForm: {
          id:null,
          book_title: '',
          author: '',
          available: 0,
          total:0
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
          book_title: '',
          author: '',
          available: 0,
          total:0
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/book/index').then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.books = data;
            console.log(data);
          });
    },
    
   
    addBook(){
      this.bookForm = {
        id:null,
        book_title: '',
        author: '',
        available: 0,
        total:0
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editBook(book){
      this.bookForm = {
        id: book.id,
        book_title:  book.book_title ,
        author:  book.author ,
        available: book.available ,
        total:book.total,
        status:book.status
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveBook(){
      // console.log(this.bookForm)
      //   return
      if(this.bookForm.id){
        this.$admin.post('api/book/update/'+this.bookForm.id,this.bookForm).then(({data}) => {
          this.successNotify('Update');
          this.initialize()
        })
      }
      else{
        console.log(this.bookForm)
        this.$admin.post('api/book/create',this.bookForm).then(({data}) =>{
          this.successNotify('Created');
          this.initialize()
        })
      }
    },
    deleteProduct(product){
      this.$admin.delete('api/book/delete/'+ product.id).then(({data}) => {
         this.successNotify('Deleted');
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