<template>
    <auth-form title="New Password">
        <form  @submit.prevent="resetPassword">
            <input-layout type="text" id="email" name="email" placeholder="Your Email" :errors="errors.email" v-model:value="fields.email" required/>
            <input-layout type="password" id="password" name="password" placeholder="Your password" :errors="errors.password" v-model:value="fields.password"/>
            <input-layout type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" :errors="errors.password_confirmation" v-model:value="fields.password_confirmation"/>
            <div class="text-center pt-1 mb-5 pb-1">
                <button type="submit" class="btn btn-primary color-style">Update</button>
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
            'fields' : {
                'email': '',
                'password': '',
                'password_confirmation': '',
            },
            'formData': new FormData(),
            'errors' : "",
            }
        },
        methods: {
            setFormData(){
                this.formData.set('token', this.$route.params.token ?? null);
                this.formData.set('email', this.fields.email ?? null);
                this.formData.set('password', this.fields.password ?? null);
                this.formData.set('password_confirmation', this.fields.password_confirmation ?? null);
            },
            resetPassword() {
                this.setFormData();
                axios.post('../api/reset/password', this.formData).then(response => {
                    this.$store.dispatch('getMessage', {message: response.data.message});
                    this.$router.push({name: "home"});
                }).catch(error => {
                    console.log(error);
                    if (error.response.status === 422) {
                        this.errors =  error.response.data.errors;
                    };
                    if (error.response.status === 404) {
                        var message = error.response.data.message;
                        this.$store.dispatch('getMessage', {message: message, color: 'red', time: 4000});
                    };
                });
            }
        }
    }
</script>
