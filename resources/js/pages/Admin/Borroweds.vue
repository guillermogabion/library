<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
       Borrowed Books 
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search Book Borrowed"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="borrows"
        :search="search"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.name ="{item}">

          {{item.borrowerable.first_name}} {{item.borrowerable.last_name}}
        
        </template>
        <template v-slot:item.action="{item}">
           <v-btn class="mr-2" small color="success" @click="returnBook(item)">
            Return Book
          </v-btn>
        </template>
      </v-data-table>
    </v-card>
</div>
</template>
<script>
    export default {
      data() {
        return {
            footerProps :{
                "items-per-page-options" : [5,10,15,30,]
            },
            search: '',
            student:{},
            loading: true,
            borrows: [],
            headers: [
            {
                text: 'ID',
                align: 'center',
                sortable: false,
                value: 'id',
            },
            {text: 'Borrower Name', align: 'center', value: 'name'},
            {text: 'Book Name', align: 'center', value: 'book.book_title'},
            {text: 'Book Name', align: 'center', value: 'book.book_title'},
            {text: 'Author', align: 'center', value: 'book.author'},
            {text: 'Borrowed On', align: 'center', value: 'date'},
            {text: 'Action', align: 'center', value: 'action'},
            ],
        }
      },
      
      mounted () {
          this.initialize()
      },
      methods : { 
        initialize(){
            this.$admin.get('borrow/index').then(({data}) => {
              this.borrows = data
              this.loading = false;

            })
        },

        returnBook(item){
          this.$admin.post('borrow/update/'+ item.id, item).then(({data}) => {
            console.log(item);
            this.successNotify('Return');
            this.initialize() 
          })
        }
         

      }
  }
</script>