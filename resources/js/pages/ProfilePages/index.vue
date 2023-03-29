<template>
    <div style="width: 100%">
        <div class="container-fluid">
            <hr>
            Name: {{ user.first_name }} {{ user.name }}<br>
            email: {{ user.email }}
            <hr>

            <router-link :to="{name: 'editProfile'}"  class="btn btn-primary btn-block fa-lg color-style mb-3">Update Profile</router-link>
            <router-link :to="{name: 'updatePassword'}"  class="btn btn-primary btn-block fa-lg color-style mb-3">Update Password</router-link>            
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
