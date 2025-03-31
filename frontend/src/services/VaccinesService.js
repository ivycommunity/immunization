import axios from "axios";
import userStore from "@/stores/userStore";
import API from "./API";

export default class VaccinesService {
    constructor() {
        this.userStore = userStore();
        this.api = API;
    }

    async getAllVaccines() {
        try {
            const response = await this.api.get("/vaccines");
            return response.data;
        } catch (error) {
            console.error("Error fetching vaccines:", error);
            throw error;
        }
    }

    async getVaccineById(vaccine_id) {
        try {
            const response = await this.api.get(`/vaccines/${vaccine_id}`);
            return response.data;
        } catch (error) {
            console.error(`Error fetching vaccine ${vaccine_id}:`, error);
            throw error;
        }
    }
}