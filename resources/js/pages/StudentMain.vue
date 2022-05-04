<template>
  <v-app id="inspire">
    <v-app-bar
      app absolute  
      color="primary" 
      class="text-white"
    >
      <v-avatar
          class="mr-10"
      >
      <img
          src="/images/logo.png"
        class="at-logo" >
      </v-avatar>
      
      <v-toolbar-title>Tan Ting Bing Memorial Colleges Foundation Inc. Library System</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn small @click="logoutUser">
        <v-icon >
          mdi-logout
        </v-icon>
        Logout
      </v-btn>
      
    </v-app-bar>

    <!-- <v-main class="light-green accent-2 "> -->
    <v-main class="yellow lighten-1 ">
      <v-container>
        <transition 
                  
          >
              <router-view> </router-view>
        </transition>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      links: [
        { text : 'Books',link : '/books'},
      
        // { text : 'Enrolled Subjects',link : '/enrolled_subjects'},
      ],
    }),
    methods : {
        logoutUser(){
            this.$admin.post('/logout').then((response) => {
                localStorage.removeItem("token")
                localStorage.removeItem('user_type')
                this.$router.push('/login')
            })
        },
    },
  }
</script>