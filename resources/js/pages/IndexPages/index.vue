<template>
    <div style="width: 100%">
        <div class="container-fluid">
            <nav-bar :user="user"></nav-bar><br>
            <message-box :message=message></message-box>
            <router-view :key="$route.path"  :user=user></router-view>
            





            <!--
                <global-layout>

                <message-box :message=message></message-box>
                <router-view :key="$route.path" :user=user></router-view>
            </global-layout>
            -->

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
            console.log('Index page loaded');
            //this.$store.dispatch('getMessage', {message: "dit is het bericht", color: 'blue', time: 3000});
        }
    }
</script>

<style scoped>

</style>
