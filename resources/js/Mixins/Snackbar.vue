<script>
export default {
    data: vm => ({}),
    methods: {
      
        successNotify(event) {
            this.$root.$notify(
                event+" Successfully",
                {
                    left : false, right : true,bottom : true, top : false
                },
                "success"
            )
        },
        errorNotify(message) { 
            this.$root.$notify(
                message,
                {
                    left : false, right : true,bottom : true, top : false
                },
                "error"
            )
        }
    }
};
</script>
