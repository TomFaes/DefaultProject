<template>
    <auth-form title="Create an account">
        <form  @submit.prevent="registerAccount">
            <input-layout type="text" id="first_name" name="first_name" placeholder="Your First name" :errors="errors.first_name" v-model:value="fields.first_name"/>
            <input-layout type="text" id="name" name="name" placeholder="Your Name" :errors="errors.name" v-model:value="fields.name"/>
            <input-layout type="text" id="email" name="email" placeholder="Your Email" :errors="errors.email" v-model:value="fields.email"/>
            <input-layout type="password" id="password" name="password" placeholder="Your password" :errors="errors.password" v-model:value="fields.password"/>
            <input-layout type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" :errors="errors.confirm_password" v-model:value="fields.confirm_password"/>
            <div class="text-center pt-1 mb-5 pb-1">
                <button class="btn btn-primary btn-block fa-lg color-style mb-3">Register</button>
            </div>
            <p class="text-center text-muted mt-5 mb-0">Have already an account?
                <router-link to="login"  class="fw-bold text-body"><u>Login here</u></router-link>
            </p>
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
            this.formData.set('first_name', this.fields.first_name ?? null);
            this.formData.set('name', this.fields.name ?? null);
            this.formData.set('email', this.fields.email ?? null);
            this.formData.append('password', this.fields.password ?? null);
            this.formData.set('confirm_password', this.fields.confirm_password ?? null);
        },

        registerAccount(){
            this.setFormData();
            axios.post('./api/register', this.formData).then(response => {
                this.fields = {}; //Clear input fields.
                this.errors = {};
                this.formData =  new FormData();
                this.$store.dispatch('getMessage', {message: response.data.message});
                this.$router.push({name: "home"});
            }).catch(error => {
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

    }
}
</script>

<style scoped>

</style>
