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
        :headers="headers"
        :items="books"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.status="{ item }">
          <!-- <v-switch
            color="light-blue"
            v-model="item.status"
            @click="changeBookStatus(item)"
          ></v-switch> -->
          <v-select
              :items="statuses"
              item-text="value"
              item-value="id"
              @change="changeBookStatus(item)"
              v-model="item.status"
          ></v-select>
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
        books: [],
        statuses:[
                  {
                    id: 1,
                    value:'Available'
                  },
                  {
                    id: 0,
                    value:'Unavailable'
                  }
              ],
        loading: true,
        footerProps :{
          "items-per-page-options" : [5,10,15, 30, ]
        },
        headers: [
          { text: "Book Title", value: "book_title" },
          { text: "Author", value: "author" },
          { text: "Count", value: "count" },
          { text: "Status", value: "status" },
          { text: "Actions", value: "actions", sortable: false, },
        ],
        addition_edition_dailog: false,
        bookForm: {
          id:null,
          book_title: '',
          author: '',
          count: 0,
          status:1,
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
          count: 0,
          status:1,
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('book/index').then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.books = data;
            console.log(data);
          });
    },
    
    changeBookStatus(book){
      this.bookForm = {
        id: book.id,
        book_title:  book.book_title ,
        author:  book.author ,
        count: book.count ,
        status: book.status ,
        // image: '/storage/'+product.image 
      }
      this.saveBook()
    },
    addBook(){
      this.bookForm = {
        id:null,
        book_title: '',
        author: '',
        count: 0,
        status:1,
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editBook(book){
      this.bookForm = {
        id: book.id,
        book_title:  book.book_title ,
        author:  book.author ,
        count: book.count ,
        status: book.status ,
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveBook(){
      // console.log(this.bookForm)
      //   return
      if(this.bookForm.id){
        this.$admin.post('book/update/'+this.bookForm.id,this.bookForm).then(({data}) => {
          this.successNotify('update');
          this.initialize()
        })
      }
      else{
        console.log(this.bookForm)
        this.$admin.post('book/create',this.bookForm).then(({data}) =>{
          this.successNotify('create');
          this.initialize()
        })
      }
    },
    deleteProduct(product){
      this.$admin.delete('book/delete/'+ product.id).then(({data}) => {
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