<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Visitors
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addVisitor"
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
        :items="visitors"
        :search="search"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.actions="{item}">
           <v-btn class="mr-2" x-small color="success" @click="showDialog = true, generate(item)">
            View QR
          </v-btn>
           <v-icon 
            class="mr-2" 
            @click="$router.push('/visitor-view/'+item.id)"
          >
            mdi-eye
          </v-icon>
          <v-icon
            class="mr-2"
            @click="editVisitor(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteVisitor(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <VisitorForm :form="visitorForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveVisitor()" />
    <v-row justify="center">
      <v-dialog
          v-model="showDialog"
          persistent
          max-width="290"
      >
        <v-card>
          <v-card-title class="primary headline" style="font-weight:bold; color:white;">
              Visitor QR Code
              <v-spacer></v-spacer>
                <v-icon color="white" @click="showDialog = false" >
                    mdi-close-circle-outline
                </v-icon>
          </v-card-title>
          <v-card-text class="mt-4">Please Take a Pic or Screenshot this.</v-card-text>
          <v-card-actions>
                <div class="mt-5 mb-5 mx-auto " v-html="qr_code"></div>
          </v-card-actions>
      </v-card>
      </v-dialog>
    </v-row>
</div>
</template>
<script>
  import VisitorForm from '../../components/adminForms/Visitor.vue'
  export default {
    components: {
      VisitorForm
    },
    data() {
      return {
        visitors: [],
        qr_code:{},
        search: '',
        showDialog: false,
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
          { text: "First Name", value: "first_name",align: 'center' },
          { text: "Last Name", value: "last_name",align: 'center' },
          { text: "Phone Number", value: "phone_number",align: 'center' },
          { text: "Email", value: "email",align: 'center' },
          { text: "Actions", value: "actions", sortable: false,align: 'center' },
        ],
        addition_edition_dailog: false,
        visitorForm: {
          id:null,
          first_name: '',
          last_name: '',
          phone_number: '',
          email: '',
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
        this.visitorForm = {
          id:null,
          first_name: '',
          last_name: '',
          phone_number: '',
          email: '',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/visitor/index').then((data) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.visitors = data.data;
            console.log(data);
            // this.page = data.page;
            // this.total = data.total;
            // this.numberOfPages = data.last_page;
          });
    },

    addVisitor(){
      this.visitorForm = {
        id:null,
        first_name: '',
        last_name: '',
        phone_number: '',
        email: '',
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },

    editVisitor(visitor){
      this.visitorForm = {
        id: visitor.id,
        first_name:  visitor.first_name ,
        last_name:  visitor.last_name ,
        phone_number:  visitor.phone_number ,
        email:  visitor.email, 
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },

    saveVisitor(){
      console.log(this.visitorForm)
      if(this.visitorForm.id){
        this.$admin.post('api/visitor/update/'+this.visitorForm.id,this.visitorForm).then(({data}) => {
          console.log(data);
          this.successNotify('Update');
          this.initialize()
        })
      }
      else{
        this.$admin.post('api/visitor/create',this.visitorForm).then(({data}) =>{
          this.successNotify('Created');
          this.initialize()
        })
      }
    },

    generate(visitor){
      this.$admin.get('api/visitor/generate/'+ visitor.id).then(({data}) => {
        this.qr_code =  data
      })
    },

    deleteVisitor(visitor){
      this.$admin.delete('api/visitor/delete/'+ visitor.id).then(({data}) => {
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