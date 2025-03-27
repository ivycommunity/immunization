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

        // async update({
        //     first_name = this.user.first_name || "",
        //     last_name = this.user.last_name || "",
        //     email = this.user.email || "",
        //     password = this.user.password || this.user.national_id,
        //     phone_number = this.user.phone_number || "",
        //     date_of_birth = this.user.date_of_birth || "",
        //     address = this.user.address || "",
        //     marital_status = this.user.marital_status || "",
        //     next_of_kin = this.user.next_of_kin || "",
        //     next_of_kin_contact = this.user.next_of_kin_contact || "",
        //     no_of_children = this.user.no_of_children || 0
        // }) {
        //     try {
        //         const response = await API.put(`/guardians/${this.user.id}`, {
        //             first_name,
        //             last_name,
        //             email,
        //             password,
        //             phone_number,
        //             date_of_birth,
        //             address,
        //             marital_status,
        //             next_of_kin,
        //             next_of_kin_contact,
        //             no_of_children
        //         });

        //         const { user, token } = response.data;

        //         this.user = user;
        //         localStorage.setItem('user_data', JSON.stringify(user));

        //         if (token) {
        //             this.token = token;
        //             localStorage.setItem('user_token', token);
        //         }

        //         return user;

        //     } catch (error) {
        //         this.errors = error.response?.data?.errors || {};
        //         return Promise.reject(error);
        //     }
        // },
        async updated(updatedData) {
            try {
                // Only send fields that are actually being updated
                const payload = {
                    first_name: updatedData.first_name || undefined,
                    last_name: updatedData.last_name || undefined,
                    email: updatedData.email || undefined,
                    phone_number: updatedData.phone_number || undefined,
                    date_of_birth: updatedData.date_of_birth || undefined,
                    address: updatedData.address || undefined,
                    marital_status: updatedData.marital_status || undefined,
                    next_of_kin: updatedData.next_of_kin || undefined,
                    next_of_kin_contact: updatedData.next_of_kin_contact || undefined,
                    no_of_children: updatedData.no_of_children || undefined
                };
        
                // Remove undefined fields to avoid sending empty values
                Object.keys(payload).forEach(key => payload[key] === undefined && delete payload[key]);
        
                const response = await API.put(`/guardians/${this.user.id}`, payload);
        
                // Match the backend response structure
                const { message, guardian } = response.data;
        
                // Update local user data
                if (guardian) {
                    this.user = guardian;
                    localStorage.setItem('user_data', JSON.stringify(guardian));
                }
        
                return {
                    message: message || 'Guardian updated successfully',
                    guardian
                };
        
            } catch (error) {
                console.error('Update guardian error:', error);
                
                // Handle validation errors
                if (error.response?.status === 422) {
                    this.errors = error.response.data.errors || {};
                    return Promise.reject({
                        message: 'Validation failed',
                        errors: this.errors
                    });
                }
        
                // Handle not found
                if (error.response?.status === 404) {
                    return Promise.reject({
                        message: 'Guardian not found'
                    });
                }
        
                // Handle other errors
                return Promise.reject({
                    message: error.response?.data?.message || 'Failed to update guardian',
                    error: error.response?.data?.error || error.message
                });
            }
        },

        // In stores/userStore.js
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