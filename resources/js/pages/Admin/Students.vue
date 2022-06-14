<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        List of Students
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addStudent"
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
        :items="students"
        :search="search"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.courseYear="{item}">
          {{item.year}} {{item.course}}
        </template>
        <template v-slot:item.actions="{item}">
          <v-btn class="mr-2" x-small color="success" @click="showDialog = true, generate(item)">
            View QR
          </v-btn>
          <v-icon 
            class="mr-2" 
            @click="$router.push('/student-view/'+item.id)"
          >
            mdi-eye
          </v-icon>
          <v-icon
            class="mr-2"
            @click="editStudent(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteStudent(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <StudentForm :form="studentForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveStudent()" />
    <v-row justify="center">
      <v-dialog
          v-model="showDialog"
          persistent
          max-width="290"
      >
        <v-card>
          <v-card-title class="primary headline" style="font-weight:bold; color:white;">
              Student QR Code
              <v-spacer></v-spacer>
                <v-icon color="white" @click="showDialog = false" >
                    mdi-close-circle-outline
                </v-icon>
          </v-card-title>
          <v-card-actions>
                <div class="mt-5 mb-5 mx-auto " v-html="qr_code"></div>
          </v-card-actions>
          <v-spacer></v-spacer>
            <div align="center">
              <span style="font-weight: bold; font-color: black;">{{ editedItem.last_name }}, {{ editedItem.first_name }}</span>
              <br>
              <span style="font-size: 10px; font-color: black;">Name</span>
              <br>
              <span style="font-weight: bold; font-color: black;">{{ editedItem.phone_number }}</span>
              <br>
              <span style="font-size: 10px; font-color: black;">Contact Number</span>
            </div>
          <v-spacer></v-spacer>
      </v-card>
      </v-dialog>
    </v-row>
</div>
</template>
<script>
  import StudentForm from '../../components/adminForms/Student.vue'
  export default {
    components: {
      StudentForm
    },
    data() {
      return {
        students: [],
        qr_code:{},
        search: '',
        showDialog: false,
        loading: true,
        footerProps :{
          "items-per-page-options" : [5,10,15,30,]
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
          { text: "Year/Course", value: "courseYear",align: 'center' },
          // { text: "Year", value: "year",align: 'center' },
          { text: "Actions", value: "actions", sortable: false,align: 'center' },
        ],
        addition_edition_dailog: false,
        studentForm: {
          id:null,
          first_name: '',
          last_name: '',
          phone_number: '',
          email: '',
          course:'',
          year: null,
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        },

         editedIndex: -1,
          editedItem: {
          first_name: '',
          last_name: 0,
          phone_number: 0,
          courseYear: 0,
          },
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
        this.studentForm = {
          id:null,
          first_name: '',
          last_name: '',
          phone_number: '',
          email: '',
          course:'',
          year: '',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('api/student/index')
          .then((data) => {
            // console.log(data);
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.students = data.data;
          });
    },

    addStudent(){
      this.studentForm = {
        id:null,
        first_name: '',
        last_name: '',
        phone_number: '',
        email: '',
        course:'',
        year: '',
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },

    editStudent(student){
      this.studentForm = {
        id: student.id,
        first_name:  student.first_name ,
        last_name:  student.last_name ,
        phone_number: student.phone_number,
        email:  student.email ,
        course: student.course ,
        year: student.year ,
        // password: student.password,
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },

    saveStudent(){
      if(this.studentForm.id){
        console.log(this.studentForm);
        this.$admin.post('api/student/update/'+this.studentForm.id,this.studentForm).then(({data}) => {
          this.successNotify('Update');
          console.log(data);
          this.initialize()
        })
      }
      else{
          // console.log(this.studentForm);
          // return;
        this.$admin.post('api/student/create',this.studentForm).then(({data}) =>{
          this.successNotify('Created');
          this.initialize()
        })
      }
    },

    generate(student){
      this.editedIndex = this.students.indexOf(student)
      this.editedItem = Object.assign({}, student)
      this.$admin.get('api/student/generate/'+ student.id).then(({data}) => {
        this.qr_code =  data
      })
    },

    deleteStudent(student){
      this.$admin.delete('api/student/delete/'+ student.id).then(({data}) => {
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