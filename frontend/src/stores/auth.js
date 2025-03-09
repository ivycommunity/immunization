import { defineStore } from "pinia";

export const useAuthStore = defineStore("authStore", {
	state: () => {
		return {
			user: null,
			errors: {},
		};
	},
	actions: {
		//Get the authenticated user
		async getUser() {
			if (localStorage.getItem("token")) {
				const res = await fetch("/api/user", {
					headers: {
						authorization: `Bearer ${localStorage.getItem("token")}`,
					},
				});
				const data = await res.json();
				if (res) {
					this.user = data;
				}
				console.log(data);
			}
		},

		// Login or Register a user
		async authenticate(apiRoute, formData) {
			const res = await fetch(`/api/${apiRoute}`, {
				method: "post",
				body: JSON.stringify(formData),
			});

			const data = await res.json();
			if (data.errors) {
				this.errors = data.errors;
				console.log(this.errors);
				return { success: false };
			} else {
				console.log(data);
				localStorage.setItem("token", data.token);
                this.errors = {}
				this.user = data.user;
				if (apiRoute === "login") {
					if (this.user.role === 'nurse') {
                        this.router.push({ name: "hospital.patients" });
                    }
				}
				return { success: true };
			}
		},

		// Logout a user
        async logout() {
            const res = await fetch('/api/logout', {
                method: 'post',
                headers: {
                    authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            })

            const data = await res.json()
            console.log(data);

            if ( res.ok) {
                this.user = null
                this.errors = {}
                localStorage.removeItem('token')
                this.router.push({ name: 'home' })
            }
        }
	},
});
