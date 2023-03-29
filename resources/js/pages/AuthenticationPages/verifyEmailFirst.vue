<template>
    <auth-form title="Verify your email first">
        <div class="text-center pt-1 mb-5 pb-1">
            <button class="btn btn-primary color-style" @click.prevent="resendVerifyMail()">Resend verify email</button>
        </div>
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

            }
        },

        props: {

        },

        methods: {
            resendVerifyMail(){
                axios.get('./api/email/resend', this.formData).then(response => {
                    this.$store.dispatch('getMessage', {message: response.data.message});
                }).catch(error => {
                    if (error.response.status === 404) {
                        var message = error.response.data.message;
                        this.$store.dispatch('getMessage', {message: message, color: 'red', time: 4000});
                    }
                });
            }
        },

        mounted () {

        }
    }
</script>

<style scoped>
    .gradient-custom-4 {
        /* fallback for old browsers */
        background: #84fab0;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1))
    }

</style>
