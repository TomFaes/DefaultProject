import { createWebHistory, createRouter } from "vue-router";
import store from '../services/store';
import axios from 'axios';

import Home from '../pages/IndexPages/home.vue';
import CookiePolicy from  '../pages/CookiePolicy/cookiePolicy.vue';
import PageNotFound from '../pages/systemPages/PageNotFound.vue';

import Login from '../pages/AuthenticationPages/login.vue';
import Register from '../pages/AuthenticationPages/register.vue';
import verifyEmailFirst from '../pages/AuthenticationPages/verifyEmailFirst.vue'
import ForgotPassword from '../pages/AuthenticationPages/forgotPassword.vue';
import ResetPasswordForm from '../pages/AuthenticationPages/resetPasswordForm.vue';
import Profile from '../pages/ProfilePages/index.vue';
import EditProfile from '../pages/ProfilePages/input.vue';
import UpdatePassword from '../pages/ProfilePages/updatePassword.vue'

var localPath = "";
if(import.meta.env.DEV == true){
    localPath = import.meta.env.VITE_APP_URL;
}

const router = createRouter({
    mode: 'history',
    linkActiveClass: 'active',
    transitionOnLoad: true,
    history: createWebHistory(),
    routes:[
        {
            path: localPath + '/',
            name: 'home',
            component: Home,
            meta: {
                auth: true,
            }
        },
        {
            path: localPath + '/cookie-policy',
            name: 'cookiePolicy',
            component: CookiePolicy,
        },
        {
            path: localPath + '/login',
            name: 'login',
            component: Login,
        },
        {
            path: localPath + '/register',
            name: 'register',
            component: Register,
        },
        {
            path: localPath + '/verify_email_first',
            name: 'verifyEmailFirst',
            component: verifyEmailFirst,
        },
        {
            path: localPath + '/reset-password',
            name: 'reset-password',
            component: ForgotPassword,
            meta: {
                auth:false
            }
        },
        {
            path: localPath + '/reset-password/:token',
            name: 'reset-password-form',
            component: ResetPasswordForm,
            meta: {
              auth:false
            }
        },
        {
            path: localPath + '/profile',
            name: 'profile',
            component: Profile,
            meta: {
                auth:true
            },
        },
        {
            path: localPath + '/profile/edit',
            name: 'editProfile',
            component: EditProfile,
            meta: {
                auth:true
            },
        },
        {
            path: localPath + '/profile/password',
            name: 'updatePassword',
            component: UpdatePassword,
            meta: {
              auth:true
            }
        },
        
        {
            path: localPath + '/guest',
            name: 'guest',
            component: Login,
        },

        {
            path: localPath + '/:pathMatch(.*)*',
            name: 'PageNotFound',
            component: PageNotFound,
        }
    ]
});

router.beforeEach((to, from, next) => {
    //check if authentication is needed for the route
    if(to.meta.auth == true){
        //get the user: from the database or from the store
        let getUser = new Promise((resolve, reject) => {
            if(store.state.loggedInUser == ""){
                var user = axios({
                    method: 'get',
                    url : localPath + '/api/profile'
                })
                .then(function (response) {
                    store.commit("setAuthentication", true);
                    store.commit("setRole", response.data.data.role);
                    store.commit("setLoggedInUser", response.data.data);
                    return response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }else{
               var user = store.state.loggedInUser;
            }
            resolve(user)
        }, 250) ;

        getUser.then((user) =>{
            if(to.name == 'home' && user == undefined){
                next();
                return;
            }

            if(to.fullPath == '/' && user == undefined){
                next();
                return;
            }

            if(user == undefined){
                next({ name: 'guest'});
                return;
            }
            if(!user.email_verified_at){
                next({name: 'verifyEmailFirst'});
                return;
            }

            if(user){
                next();
            }
        });
    }else{
         next();
    }
});



export default router;
