import { defineStore } from "pinia";
import axios from "axios";

const TOKEN = localStorage.getItem('user_token') || "";
const USER = JSON.parse(localStorage.getItem('user_data') || "{}");

const API = axios.create({
    baseURL: '/api',
    withCredentials: true,
})

export default defineStore('user', {
    state: () => ({
        token: TOKEN,
        user: USER,
        errors:{},
        isAuthenticated: !!TOKEN,
    }),
    actions: {
        async login({ email = null, phone_number = null, password }) {
            try {
                const response = await API.post('/login', {
                    email: email || null,
                    phone_number: phone_number || null,
                    password: password,
                });

                const { user, token } = response.data;

                this.token = token;
                this.user = user;
                this.isAuthenticated = true;

                localStorage.setItem('user_token', token);
                localStorage.setItem('user_data', JSON.stringify(user));
                
                return user;

            } catch (error) {
                return Promise.reject(error);
            }
        },

        // async changePassword (newPassword){ // Not in the backend yet
        //     try{
        //         const response = await API.put(
        //             '/updatePassword',{
        //                 password : newPassword
        //             }
        //         )
        //     }catch(error){

        //     }
        // },
        
        async logout() {
            this.token = "";
            this.user = {};
            this.isAuthenticated = false;
            
            try {
                await API.post('/logout');
                localStorage.removeItem('user_token');
                localStorage.removeItem('user_data');
            } catch (error) {
                console.error('Logout failed:', error);
                return Promise.reject(error);
            }
        }
    },
    getters: {
        userFullName: (state) => {
            if (state.user.first_name || state.user.last_name) {
                return `${state.user.first_name || ''} ${state.user.last_name || ''}`.trim();
            }
            return '';
        },
        isLoggedIn: (state) => state.isAuthenticated
    },
});