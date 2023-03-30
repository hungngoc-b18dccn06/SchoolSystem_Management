import {defineStore} from "pinia";
import api from "@/api";
import {format} from "date-fns";
import CONST, {ApiConstant, DEFAULT} from "@/const";
import axios from "axios";
import { da } from "date-fns/locale";
export interface  User {
    id?: number,
    email: string;
    status: string;
    role:string;
    name?: string;
    created_at?: string;
}
export interface ParamsSearch {
    search_text?: string;
}
export interface Pagination {
    currentPage: number,
    total: number,
    perPage: number
}
interface FormUser {
    first_name: string;
    last_name: string;
    email: string;
    status: string;
    role: string;
    password?: string;
}
interface UserStore {
    profile: User,
    users: User[],
    paramSearch: ParamsSearch,
    pagination: Pagination,
    formUser: FormUser
}
export const useUserStore = defineStore({
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
            users: [{
                id: 0,
                email: "",
                name: "",
                status: DEFAULT.USER_STATUS[0].value,
                role: DEFAULT.USER_ROLE[0].value,
                created_at: "",
            }],
            paramSearch: {},
            pagination: {
                currentPage: 1,
                total: 0,
                perPage: 0,
            },
            formUser:{
                first_name: '',
                last_name: '',
                email: '',
                status: DEFAULT.USER_STATUS[0].value,
                role: DEFAULT.USER_ROLE[0].value,
            }   
        }
    },
    getters:{
        getProfile: (state => state.profile),
        getPagination: (state => state.pagination),
        getParamSearch: (state => state.paramSearch),
        getUsers: (state => state.users.map(e => ({
            ...e,
            role: (DEFAULT.USER_ROLE.find(el => el.value == e.role) ?? DEFAULT.USER_ROLE[0]).label,
            status: (DEFAULT.USER_STATUS.find(el => el.value == e.status) ?? DEFAULT.USER_STATUS[0]).label,
        }))),
        getFormUser: (state => state.formUser)
    },
    actions:{
        async getListUser(page?: number) {
            const listUser = await api.get(ApiConstant.GET_LIST_USER, {
                params: {
                  page: page ?? 1,
                  ...this.paramSearch
                }
              });
            this.users = listUser.data.data.data.map((item:any) => ({
                ...item,
                name: item.first_name + " " + item.last_name,
                created_at: format(new Date(item.created_at), CONST.FORMAT_DATE),
            }));
            this.pagination = {
                currentPage: listUser.data.data.current_page,
                total: listUser.data.data.total,
                perPage: listUser.data.data.per_page,
            };
        },

        async apiCreateUser(data: FormUser){
            const res = await api.post(ApiConstant.CREATE_USER,data);
            await this.getListUser();
            return res
        },

        async apiUpdateUser(data: FormUser , id: number) {
            const res = await api.put(ApiConstant.UPDATE_USER(id), data);
            await this.getListUser();
            return res;
        },
        async getUserDetail(id: number) {
            const response = await api.get<any>(ApiConstant.GET_DETAIL_USER(id));
            this.formUser = response.data.data;
        },
        async deleteUser(id: number) {
            const res = await api.delete<any>(ApiConstant.DELETE_USER(id));
            this.getListUser();
            return res;
        },
        async getProfileDetail() {
            try {
                const response = await api.get<any>(ApiConstant.GET_PROFILE);
                const profileInfo = response.data.data.user;
                this.profile = {
                    ...profileInfo,
                    name: profileInfo.first_name + " " + profileInfo.last_name,
                };
            } catch (err) {
                console.log(err);
            }
        },
    }
})