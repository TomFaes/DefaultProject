<template>
    <auth-form title="Update profile">
        <form  @submit.prevent="updateProfile" method="POST" enctype="multipart/form-data">
            <input-layout type="text" id="first_name" name="first_name" placeholder="Your First name" :errors="errors.first_name" v-model:value="fields.first_name"/>
            <input-layout type="text" id="name" name="name" placeholder="Your Name" :errors="errors.name" v-model:value="fields.name"/>
            <input-layout type="text" id="email" name="email" placeholder="Your Email" :errors="errors.email" v-model:value="fields.email"/>
            <div class="text-center pt-1 mb-5 pb-1">
                <button class="btn btn-primary btn-block fa-lg color-style mb-3">Update Profile</button>
            </div>
        </form>
    </auth-form>
</template>
<script>
import inputLayout from '../../components/Layout/input.vue';
import authForm from '../../components/Layout/defautlForm.vue';

export default {
    components: {
        inputLayout,
        authForm,
    },

    data: function() {
        return {
            'fields' : {
                'first_name': '',
                'name': '',
                'email': '',
            },
            'errors' : "",
            'formData': new FormData(),
        }
    },

    props: {
        user: {},
    },

    watch: {
        user(){
            this.setData();
        }

    },

    methods: {
        setData(){
            this.fields.first_name = this.user.first_name;
            this.fields.name = this.user.name;
            this.fields.email = this.user.email;
        },

        setFormData(){
            this.formData.set('first_name', this.fields.first_name ?? null);
            this.formData.set('name', this.fields.name ?? null);
            this.formData.set('email', this.fields.email ?? null);
        },

        updateProfile(){
            this.setFormData();
            var baseUrl = import.meta.env.VITE_APP_URL;
            axios.post(baseUrl + '/api/profile', this.formData).then(response => {
                this.fields = {}; //Clear input fields.
                this.errors = {};
                this.formData =  new FormData();
                this.$store.dispatch('getLoggedInUser');
                this.$store.dispatch('getMessage', {message: response.data.message});

                this.$router.push({name: "profile"});
            }).catch(error => {
                console.log(error);
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                if (error.response.status === 404) {
                    var message = error.response.data.message;
                    this.$store.dispatch('getMessage', {message: message, color: 'red', time: 4000});
                }
            });
            
        },
    },

    mounted () {
        if(this.user){
            this.setData();
        }

    }
}
</script>

<style scoped>

</style>
