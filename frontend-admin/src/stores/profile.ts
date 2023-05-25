import {defineStore} from "pinia";
import api from "@/api";
import {format} from "date-fns";
import CONST, {ApiConstant, DEFAULT} from "@/const";
export interface  User {
    id?: number,
    email: string;
    status: string;
    role:string;
    name?: string;
    created_at?: string;
}
interface UserStore {
    profile: User,
}
export const useProfileStore = defineStore({
    id: "user",
    state: (): UserStore =>{
        return {
            profile: {
            id: 0,
            email: "",
            name: "",
            status: DEFAULT.USER_STATUS[0].value,
            role: DEFAULT.USER_ROLE[0].value,
            created_at: "",
        },
        }
    },
    getters:{
        getProfile: (state => state.profile),
    },
    actions:{
        async updateProfile(data: User) {
            try {
            const res = await api.put(ApiConstant.UPDATE_PROFILE, data);
            return res
            } catch (err) {
                console.log(err);
            }
        },
    }
})