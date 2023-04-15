<template>
    <auth-form title="Reset Password">
        <form  @submit.prevent="requestResetPassword">
            <input-layout type="text" id="email" name="email" placeholder="Your Email" :errors="errors.email" v-model:value="email" required/>
            <div class="text-center pt-1 mb-5 pb-1">
                <button type="submit" class="btn btn-primary color-style">Send Password Reset Link</button>
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

        data() {
            return {
              'email': null,
              'errors' : "",
              'formData': new FormData(),
            }
        },
        methods: {
            setFormData(){
                this.formData.set('email', this.email ?? null);
            },

            requestResetPassword() {
              this.setFormData();
                axios.post('./api/reset-password', this.formData).then(response => {
                    this.$store.dispatch('getMessage', {message: response.data.message});
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors =  error.response.data.errors;
                    };
                    if (error.response.status === 404) {
                        this.$store.dispatch('getMessage', {message: error.response.data.message, color: 'red', time: 4000});
                    };
                });
            }
        }
    }
  </script>
