import axios from "axios";
import userStore  from "@/stores/userStore";

export default class VaccinesService {
    constructor(){
        this.userStore = userStore();
        this.api = axios.create({
            baseURL: "/api",
            withCredentials: true
        });

        this.api.interceptors.request.use(config => {
            const token = this.userStore.token;
            console.log("token", token);
            if(token){
                config.headers.Authorization = `Bearer ${token}`;
            }
            return config;
        });
    }

    async getAllVaccines(){
        try{
            const response = await this.api.get("/vaccines");
            return response.data;
        } catch (error){
            throw error;
        }
    }

    async getVaccineById(vaccine_id){
        try{
            const response = await this.api.get(`/vaccines/${vaccine_id}`);
            return response.data;
        } catch (error){
            console.error(`Error fetching vaccine ${vaccine_id}:`, error);
            throw error;
        }
    }
}