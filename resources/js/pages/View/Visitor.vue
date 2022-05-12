<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
         Book/s Borrowed
      </v-card-title>
      <v-card-title>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="borrows"
        :search="search"
        :loading="loading"
        class="elevation-1"
      >

         <template v-slot:item.title ="{item}">

          {{item.book.book_title}}
        
        </template>

      </v-data-table>
       <v-spacer></v-spacer>
            <div class="d-flex justify-end mt-5 mb-5 mr-5">
                <v-btn color="black" outlined @click="$router.back()"> 
                    <v-icon left dark>mdi-logout</v-icon>
                    Back
                </v-btn>
            </div>
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
            borrows: [],
            headers: [
            {
                text: 'ID',
                align: 'center',
                sortable: false,
                value: 'id',
            },
            {text: 'Book Title', align: 'center', value: 'title'},
            {text: 'Borrowed On', align: 'center', value: 'date'},
            ],
        }
      },
      
      mounted () {
          this.initialize()
      },
      methods : { 
          initialize(){
              this.$admin.get('api/visitor/show/'+this.$route.params.id).then(({data}) => {
                  this.borrows = data
                //   this.borrow = data
              })
          },

         

    }
  }
</script>