<template>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                <div class="card card-body p-5" style="border-radius: 15px;">
                    <h4 class="text-uppercase text-center mb-5">{{ title }}</h4>
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'title': "",
        },
        
        data() {
            return {
                
            }
        },

        watch: {
            
        },

        methods: {
            
        },

        mounted(){

        }
    }
</script>

<style scoped>

</style>