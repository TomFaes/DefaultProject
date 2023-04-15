<template>
    <div style="width: 100%">
        <div class="container-fluid">
            TEST Page router


            {{ user }}

        </div>
    </div>



</template>

<script>
    export default {
        
        data: function() {
        return {
            'user': 'geen user 2',
        }
    },



        mounted () {
            console.log('TEST PAGE LOADED');


            axios.get('./sanctum/crs-cookie').then(response => {
                axios.get('./api/user', this.formData).then(response => {
                    this.user = response.data;
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                    if (error.response.status === 404) {
                        var message = error.response.data.message;
                        //this.$store.dispatch('getMessage', {message: message, color: 'red', time: 4000});

                    }
                });
            });

        }

    }
</script>

<style scoped>

</style>
