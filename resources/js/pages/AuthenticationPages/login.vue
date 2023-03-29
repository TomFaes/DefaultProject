<template>
    <auth-form title="Sign in">
        <!--
        <div class="text-center">
            <img :src="'../public/storage/dev_images/your_logo_here.jpg'" style="width: 185px;" alt="logo">
        </div>
        -->
        <form @submit.prevent="handleLogin">
            <input-layout type="text" id="email" name="email" placeholder="Your Email" :errors="errors.email" v-model:value="fields.email"/>
            <input-layout type="password" id="password" name="password" placeholder="Your password" :errors="errors.password" v-model:value="fields.password"/>
            <router-link to="reset-password"  class="text-muted">Forgot password</router-link>
            <div class="text-center pt-1 mb-5 pb-1">
                <button class="btn btn-primary btn-block fa-lg color-style mb-3">Log in</button>
            </div>
        </form>
        <div class="d-flex align-items-center justify-content-center pb-4">
            <p class="mb-0 me-2">Don't have an account?</p>
            <router-link to="register"  class="btn btn-primary btn-block fa-lg color-style mb-3">Create new</router-link>
        </div>
    </auth-form>
</template>
<script>
    import authForm from '../../components/Layout/defautlForm.vue';
    import inputLayout from '../../components/Layout/input.vue';
    
    export default {
        components: {
            authForm,
            inputLayout

        },
        data: function() {
            return {
                'fields' : {
                    email: '',
                    password: '',
                },
                'errors' : "",
                'formData': new FormData(),
            }
        },

        props: {

        },

        methods: {
            setFormData(){
                this.formData.set('email', this.fields.email ?? null);
                this.formData.append('password', this.fields.password ?? null);
            },

            handleLogin(){
                this.setFormData();
                var baseUrl = import.meta.env.VITE_APP_URL;
                axios.post('./api/login', this.formData).then(response => {
                    this.$router.push({name: "home"});
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors =  error.response.data.errors;
                    };
                    if (error.response.status === 404) {
                        var message = error.response.data.message;
                        this.$store.dispatch('getMessage', {message: message, color: 'red', time: 4000});
                    };
                });
            },
        },

        mounted () {
            
        }
    }
</script>

<style scoped>
    
</style>
