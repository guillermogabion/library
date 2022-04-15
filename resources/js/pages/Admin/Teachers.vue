<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Teachers
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addTeacher"
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
        :items="teachers"
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
            @click="$router.push('/teacher-view/'+item.id)"
          >
            mdi-eye
          </v-icon>
          <v-icon
            class="mr-2"
            @click="editTeacher(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteTeacher(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <TeacherForm :form="teacherForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveTeacher()" />
    <v-row justify="center">
      <v-dialog
          v-model="showDialog"
          persistent
          max-width="290"
      >
        <v-card>
          <v-card-title class="primary headline" style="font-weight:bold; color:white;">
              Teacher QR Code
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
  import TeacherForm from '../../components/adminForms/Teacher.vue'
  export default {
    components: {
      TeacherForm
    },
    data() {
      return {
        teachers: [],
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
          { text: "Last Name", value: "first_name",align: 'center' },
          { text: "Phone Number", value: "phone_number",align: 'center' },
          { text: "Email", value: "email",align: 'center' },
          { text: "Actions", value: "actions", sortable: false,align: 'center' },
        ],
        addition_edition_dailog: false,
        teacherForm: {
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
        this.teacherForm = {
          id:null,
          first_name: '',
          last_name: '',
          phone_number: '',
          email: '',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('teacher/index').then((data) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.teachers = data.data;
            console.log(data);
            // this.page = data.page;
            // this.total = data.total;
            // this.numberOfPages = data.last_page;
          });
      // console.log(this.teachers);
    },

    addTeacher(){
      this.teacherForm = {
        id:null,
        first_name: '',
        last_name: '',
        phone_number: '',
        email: '',
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },

    editTeacher(teacher){
      this.teacherForm = {
        id: teacher.id,
        first_name:  teacher.first_name ,
        last_name:  teacher.last_name ,
        phone_number:  teacher.phone_number ,
        email:  teacher.email, 
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },

    saveTeacher(){
      console.log(this.teacherForm)
      if(this.teacherForm.id){
        this.$admin.post('teacher/update/'+this.teacherForm.id,this.teacherForm).then(({data}) => {
          console.log(data);
          this.successNotify('update');
          this.initialize()
        })
      }
      else{
        this.$admin.post('teacher/create',this.teacherForm).then(({data}) =>{
          this.successNotify('created');
          this.initialize()
        })
      }
    },

    generate(teacher){
      this.$admin.get('teacher/generate/'+ teacher.id).then(({data}) => {
        this.qr_code =  data
      })
    },

    deleteTeacher(teacher){
      this.$admin.delete('teacher/delete/'+ teacher.id).then(({data}) => {
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