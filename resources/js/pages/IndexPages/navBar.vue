<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-warning fixed-top" id="mainNav">
            <div class="container-fluid">
                <!-- Left Side: Logo + Title-->
                <div style="width: 200px; margin-left: 20px;">
                    <router-link :to="{ name: 'home'}" class=".nav-link js-scroll-trigger">Logo/Titel</router-link>
                </div>
                
                <!-- Hamburger menu if the screen is small-->
                <div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <!-- All Menu items -->
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show" v-if="user.id > 0">
                            <router-link :to="{ name: 'profile' }" class=".nav-link js-scroll-trigger"><i class="fa fa-user fa-2x "></i></router-link>
                        </li>
                        <li class="nav-item" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show" v-if="user.id > 0">
                            <a class="nav-link js-scroll-trigger nav-link js-scroll-trigger item-link" @click.prevent="logout">Logout</a>
                        </li>
                        <li class="nav-item" data-bs-toggle="collapse"  data-bs-target=".navbar-collapse.show" v-else>
                            <router-link :to="{ name: 'login'}" class=".nav-link js-scroll-trigger" ><span>Login</span></router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br><br>
    </div>
</template>

<script>
    export default {
        data (){
            return {

            }
        },
        
        computed: {
            user(){
                return this.$store.state.loggedInUser;
            }
        },

        methods: {
            logout(){
                var baseUrl = import.meta.env.VITE_APP_URL;

                axios.post( baseUrl + '/api/logout').
                then(response => {
                    this.$store.dispatch('resetLoggedInUser');
                    this.$router.push({name: "home"});
                }).catch(error => {
                    console.log('navBar: handle server error from here');
                });
            }
        },

        mounted () {

        }
    }

</script>
<style scoped>
    a {
        color: lightgray
    }
    a :hover{
        filter: brightness(80%);
    }

    li {
        text-align: right;
        margin-right: 15px;
        margin-top: 10px;
    }

</style>
