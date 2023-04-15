<template>
    <div style="width: 100%">
        <div class="container-fluid">
            main page with some data 
        </div>
    </div>



</template>

<script>
    export default {
        components: {

        },

        props: {

         },

        data () {
            return {

            }
        },

        computed: {
            user(){
                return this.$store.state.loggedInUser;
            },
        },

        methods: {

        },

        mounted(){
            
        }
    }
</script>

<style scoped>

</style>
