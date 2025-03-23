import { defineStore } from "pinia";
import axios from "axios";

const TOKEN = localStorage.getItem('user_token') || "";
const USER = JSON.parse(localStorage.getItem('user_data') || "{}");

const API = axios.create({
    baseURL: '/api',
    withCredentials: true,
})

API.interceptors.request.use(config => {
    if (TOKEN) {
        config.headers.Authorization = `Bearer ${TOKEN}`;
    }
    return config;
});

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

        /*
         *   I think that the agents at the hospital should be the ones  
         *   to update the user national ID number for security purposes.
        */
        async update ({
            first_name = USER.first_name || "",
            last_name = USER.last_name || "",
            email = USER.email || "",
            password = USER.password || USER.national_id, // if there is no password, it should reset itself to the national ID
            phone_number = USER.phone_number || "",
            date_of_birth = USER.date_of_birth || "",
            address = USER.address || "",
            marital_status = USER.marital_status || "",
            next_of_kin = USER.next_of_kin || "",
            next_of_kin_contact = USER.next_of_kin_contact || "",
            no_of_children = USER.no_of_children || 0
        }) {
            try {
            const response = await API.put('/updateGuardian', {
                first_name,
                last_name,
                email,
                password,
                phone_number,
                date_of_birth,
                address,
                marital_status,
                next_of_kin,
                next_of_kin_contact,
                no_of_children
            });

            const { user } = response.data;

            this.user = user;
            localStorage.setItem('user_data', JSON.stringify(user));

            return user;

            } catch (error) {
            this.errors = error.response.data.errors || {};
            return Promise.reject(error);
            }
        },

        async logout() {
            try {
                await API.post('/logout');
                localStorage.removeItem('user_token');
                localStorage.removeItem('user_data');
                this.token = "";
                this.user = {};
                this.isAuthenticated = false;
            } catch (error) {
                console.error('Logout failed:', error);
                return Promise.reject(error);
            }
        }
    },
    getters: {
        getUserID: (state) => {
            return state.user.id || '';
        },
        userFullName: (state) => {
            if (state.user.first_name || state.user.last_name) {
                return `${state.user.first_name || ''} ${state.user.last_name || ''}`.trim();
            }
            return '';
        },
        isLoggedIn: (state) => state.isAuthenticated,
        
        fullName: (state) => {
            return `${state.user.first_name || ''} ${state.user.last_name || ''}`.trim();
        },
        no_of_children: (state) => {
            return state.user.no_of_children || 0;
        }
    },
});