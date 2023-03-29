<template>
    <auth-form title="Update password">
        <form  @submit.prevent="updatePassword" method="POST" enctype="multipart/form-data">
            <input-layout type="password" id="password" name="password" placeholder="Your password" :errors="errors.password" v-model:value="fields.password"/>
            <input-layout type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" :errors="errors.confirm_password" v-model:value="fields.confirm_password"/>          
            <div class="text-center pt-1 mb-5 pb-1">
                <button class="btn btn-primary btn-block fa-lg color-style mb-3">Update password</button>
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

    data () {
        return {
            'fields' : {
                'password': '',
                'confirm_password': '',
            },
            'errors' : "",
            'formData': new FormData(),
        }
    },

    props: {
        
    },

    methods: {
        setFormData(){
            this.formData.set('password', this.fields.password ?? null);
            this.formData.set('confirm_password', this.fields.confirm_password ?? null);
        },

        updatePassword(){
            this.setFormData();
            var baseUrl = import.meta.env.VITE_APP_URL;
            
            axios.post(baseUrl + '/api/password', this.formData).then(response => {
                this.fields = {}; //Clear input fields.
                this.errors = {};
                this.formData =  new FormData();
                this.$store.dispatch('getMessage', {message: response.data.message});
                this.$router.push({name: "profile"});
            }).catch(error => {
                console.log(error);
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                if (error.response.status === 404) {
                    this.$store.dispatch('getMessage', {message: error.response.data.message, color: 'red', time: 4000});
                }
            });
        },
    },

    mounted () {

    }
}
</script>

<style scoped>

</style>
