<template>
   <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3"> <span class="text-danger"></span> Sorry, deze pagina kon niet gevonden worden.</p>
            <p class="lead">
                The page you’re looking for doesn’t exist.
            </p>
            <router-link :to="{ name: 'home'}" class="btn btn btn-primary btn-block fa-lg color-style mb-3">Home</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        mounted(){

        }
    }
</script>

<style scoped>

</style>
