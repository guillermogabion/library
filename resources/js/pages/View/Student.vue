<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
       {{student.first_name}} Book/s Borrowed
      </v-card-title>
      <v-card-title>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="borrows"
        :loading="loading"
        class="elevation-1"
      >
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
            student:{},
            borrows: [],
            loading: true,
            headers: [
            {
                text: 'ID',
                align: 'center',
                sortable: false,
                value: 'id',
            },
            {text: 'Book ID', align: 'center', value: 'book_id'},
            {text: 'Borrowed On', align: 'center', value: 'date'},
            ],
        }
      },
      
      mounted () {
          this.initialize()
      },
      methods : { 
          initialize(){
              this.$admin.get('/student/show/'+this.$route.params.id).then(({data}) => {
                  this.student = data
                  this.borrows = data.borrows
                  this.loading = false;

                //   this.borrow = data
              })
          },

         

    }
  }
</script>