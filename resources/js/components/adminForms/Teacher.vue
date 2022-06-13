<template>
  <v-row justify="center">
    <v-dialog
      v-model="addTeacherDialog"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?'Edit' :'Add New'}} Teacher</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col      
                    cols="12"
                    sm="12"
                    md="12"
                >
                    <v-row>
                        <v-col>
                            <v-text-field
                                label="*First Name"
                                required
                                v-model="form.first_name"
                            ></v-text-field><v-text-field
                                label="*Last Name"
                                required
                                v-model="form.last_name"
                            ></v-text-field><v-text-field
                                label="*Phone Number"
                                required
                                placeholder="Ex. 9261231234"
                                v-model="form.phone_number"
                            ></v-text-field>
                            <v-text-field
                                label="*Email"
                                type="email"
                                required
                                v-model="form.email"
                            ></v-text-field>
                            
                            <p>*indicates required field</p>
                        </v-col>
                        <!-- <v-col
                            cols="6"
                            sm="6"
                            md="6"
                        >

                            <v-img
                                lazy-src="https://picsum.photos/id/11/10/6"
                                max-height="250"
                                max-width="250"
                                height="200"
                                :src="form.image ? form.image : 'https://cdn.vuetifyjs.com/images/parallax/material2.jpg'"
                            ></v-img>
                            <v-btn 
                                icon 
                                large
                                color="light-blue" 
                                @click="$refs.inputUpload.click()"
                            >
                                <v-icon>mdi-image-plus</v-icon>
                            </v-btn>
                            <input v-show="false" ref="inputUpload" type="file" @change="processImage" >
                        </v-col> -->
                        
                    </v-row>
                </v-col>
            
            </v-row>
          </v-container>
       
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            text
            @click="$emit('close')"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="$emit('save')"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
  export default {
    props: {
        dialogState: {
            type: Boolean,
            required: true
        },
        form: {
            type: Object,
            required: true,
            default: {
                id:null,
                first_name: '',
                last_name: '',
                phone_number: '',
                email:'',
                // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
            }
        }
    },
    data: () => ({
      dialog: false,
    }),
    methods : {
        // processImage(e){
      
        //   var fileReader = new FileReader()
        //   fileReader.readAsDataURL(e.target.files[0])
        //   fileReader.onload = (e) => {
        //     this.form.image = e.target.result
        //   }
        // },
    },
    mouted(){
        
    },
    computed : {
        addTeacherDialog(){
            return this.dialogState
        }
    }
    
  }
</script>