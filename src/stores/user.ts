import {defineStore} from "pinia";
import api from "@/api";
import {format} from "date-fns";
import CONST, {ApiConstant, DEFAULT} from "@/const";
import axios from "axios";
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

interface UserStore {
    profile: User,
    users: User[],
    paramSearch: ParamsSearch,
    pagination: Pagination,
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
    },
    actions:{
        async getListUser(page?: number) {
            // const listUser = await api.get(ApiConstant.GET_LIST_USER, {
            //     headers: {
            //       Authorization: 'Bearer 408|CciCcG1uWp81smpDrdAfOi2nF0EwuZtpisqlnQSX'
            //     },
            //     params: {
            //       page: page ?? 1,
            //       ...this.paramSearch
            //     }
            //   });
              const listUser = await axios.get('http://dev.base.api.skylab.vn/api/users', {headers: {
                Authorization: 'Bearer 408|CciCcG1uWp81smpDrdAfOi2nF0EwuZtpisqlnQSX'
            }});  
            this.users = listUser.data.data.data.map((item:any) => ({
                ...item,
                name: item.first_name + " " + item.last_name,
                created_at: format(new Date(item.created_at), CONST.FORMAT_DATE),
            }));
    
        },
    
    }
})