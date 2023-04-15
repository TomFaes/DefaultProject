<template>
    <div>
        <authForm title="Profile">
            Name: {{ user.first_name }} {{ user.name }}<br>
            email: {{ user.email }}
            <hr>
            <div class="text-center pt-1 mb-5 pb-1">
                <router-link :to="{name: 'editProfile'}"  class="btn btn-primary btn-block fa-lg color-style mb-3">Update Profile</router-link>
                <router-link :to="{name: 'updatePassword'}"  class="btn btn-primary btn-block fa-lg color-style mb-3">Update Password</router-link>
            </div>    
        </authForm>
        <hr>
        <authForm title="Connections">
            <div v-for="providers in user.providers" :key="providers.id">
                <div class="provider-icons" v-if="providers.provider == 'microsoft'"><i class="fab fa-windows"></i></div>
                <div class="provider-icons" v-if="providers.provider == 'google'" style="background-color: #dd4b39;"><i class="fab fa-google"></i></div>
            </div>
        </authForm>
    </div>
</template>

<script>
    import authForm from '../../components/Layout/defautlForm.vue';

    export default {
        components: {
            authForm,
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
