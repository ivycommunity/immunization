import { defineStore } from "pinia";
import axios from "axios";
import myAPI from "@/services/API";

const API = myAPI;

export default defineStore('user', {
    state: () => ({
        token: localStorage.getItem('user_token') || "",
        user: JSON.parse(localStorage.getItem('user_data') || "{}"),
        errors: {},
        isAuthenticated: !!localStorage.getItem('user_token'),
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
        async update(payload) {
            try {
              const response = await API.put(`/guardians/${this.user.id}`, payload);
              
              this.user = response.data.guardian;
              localStorage.setItem('user_data', JSON.stringify(this.user));
              
              return {
                message: 'Profile updated successfully',
                guardian: this.user
              };
            } catch (error) {
              console.error('Update error:', error);
              throw {
                message: error.response?.data?.message || 'Failed to update profile',
                errors: error.response?.data?.errors || {}
              };
            }
        },

        async changePassword(payload) {
            
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
        getUserID: (state) => state.user.id || '',
        userFullName: (state) => {
            return `${state.user.first_name || ''} ${state.user.last_name || ''}`.trim();
        },
        isLoggedIn: (state) => state.isAuthenticated,
        fullName: (state) => {
            return `${state.user.first_name || ''} ${state.user.last_name || ''}`.trim();
        },
        no_of_children: (state) => state.user.no_of_children || 0
    },
});