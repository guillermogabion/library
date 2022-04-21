<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
       Borrowed Books List
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
        :items="borrow"
        :search="search"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.action="{item}">
           <v-btn class="mr-2" small color="success">
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
            borrow: [],
            headers: [
            {
                text: 'ID',
                align: 'center',
                sortable: false,
                value: 'id',
            },
            {text: 'Book Name', align: 'center', value: 'slot_id'},
            {text: 'Author', align: 'center', value: 'date'},
            {text: 'Borrowed On', align: 'center', value: 'start_time'},
            {text: 'Action', align: 'center', value: 'action'},
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
                //   this.borrow = data
              })
          },

         

    }
  }
</script>