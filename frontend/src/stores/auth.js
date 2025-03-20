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

		// Separate Login and Register functions

		// Login a user
		async login(formData) {
			const res = await fetch(`/api/login`, {
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
				localStorage.setItem("user_id", data.user.id);
				localStorage.setItem("user_role", data.user.role);

				this.errors = {};
				this.user = data.user;
				if (this.user.role === "nurse" || this.user.role === "doctor" || this.user.role === "admin") {
					this.router.push({ name: "hospital.patients" });
				} else {
					this.router.push({ name: "userHomePage" });
				}
				return { success: true };
			}
		},

		// Register a user
		async register(formData) {
			const res = await fetch(`/api/register`, {
				method: "post",
				body: JSON.stringify(formData),
				headers: {
					authorization: `Bearer ${localStorage.getItem("token")}`,
				},
			});

			const data = await res.json();
			if (data.errors) {
				this.errors = data.errors;
				console.log(this.errors);
				return { success: false };
			} else {
				console.log(data);
				// localStorage.setItem("token", data.token);

				this.errors = {};
				this.user = data.user;
				return { success: true };
			}
		},

		// Logout a user
		async logout() {
			const res = await fetch("/api/logout", {
				method: "post",
				headers: {
					authorization: `Bearer ${localStorage.getItem("token")}`,
				},
			});

			const data = await res.json();
			console.log(data);

			if (res.ok) {
				this.user = null;
				this.errors = {};
				localStorage.removeItem("token");
				this.router.push({ name: "home" });
			}
		},
	},
});
