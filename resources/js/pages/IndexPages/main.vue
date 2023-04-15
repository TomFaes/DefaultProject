<template>
    <div style="width: 100%">
        <div class="container-fluid">
            <nav-bar></nav-bar><br>
            <message-box :message=message></message-box>
            <router-view :key="$route.path"></router-view>
        </div>
    </div>
</template>

<script>
    import navBar from '../IndexPages/navBar.vue';
    import messageBox from '../../components/tools/messageBar.vue';

    export default {
        components: {
            navBar,
            messageBox
        },

        props: {

         },

        data () {
            return {

            }
        },

        computed: {
            user(){
                return this.$store.state.loggedInUser;
            },
            message(){
                return this.$store.state.message;
            }
        },

        methods: {

        },

        mounted(){
            //this.$store.dispatch('getMessage', {message: "dit is het bericht", color: 'blue', time: 3000});
        }
    }
</script>

<style scoped>

</style>
