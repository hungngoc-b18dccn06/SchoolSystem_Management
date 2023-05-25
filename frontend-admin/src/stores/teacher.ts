import {defineStore} from "pinia";
import api from "@/api";
import {format} from "date-fns";
import CONST, {ApiConstant, DEFAULT} from "@/const";
import axios from "axios";
import { da } from "date-fns/locale";
export interface  Teacher {
    id?: number,
    gender: string;
    phone: string;
    dateofbirth:string;
    current_address?: string;
    permanent_address?: string;
}
export interface ParamsSearch {
    search_text?: string;
}
export interface Pagination {
    currentPage: number,
    total: number,
    perPage: number
}
interface FormTeacher {
    first_name: string;
    last_name: string;
    email: string;
    status: string;
    permanent_address:string,
    current_address:string,
    gender:string,
    dateofbirth:string,
    phone:string,
    role: string;
    password?: string;
}

interface UserStore {
    teachers: Teacher[],
    paramSearch: ParamsSearch,
    pagination: Pagination,
    formTeacher: FormTeacher,
}
export const useTeacherStore = defineStore({
    id: "teacher",
    state: (): UserStore =>{
        return {
            teachers: [],
            formTeacher: {
                first_name: '',
                last_name: '',
                email: '',
                permanent_address:'',
                dateofbirth: '',
                phone:'',
                current_address:'',
                gender:DEFAULT.GENDER[0].value,
                status: DEFAULT.USER_STATUS[0].value,
                role: DEFAULT.USER_ROLE[3].value,
            },
            paramSearch: {},
            pagination: {
                currentPage: 1,
                total: 0,
                perPage: 0,
            },   
        }
    },
    getters:{
        getPagination: (state => state.pagination),
        getParamSearch: (state => state.paramSearch),
        getTeachers: (state => state.teachers),
        getFormTeacher: (state => state.formTeacher)
    },
    actions:{
        async getListTeacher(page?: number) {
            const listTeacher = await api.get(ApiConstant.GET_TEACHER, {
                params: {
                  page: page ?? 1,
                  ...this.paramSearch
                }
              });
            
            this.teachers = listTeacher.data.data.data
              .filter((item: any) => item.user.role == 4)
              .map((item: any) => ({
                ...item,
                name: item.user.first_name + " " + item.user.last_name,
                email: item.user.email,
                created_at: format(new Date(item.created_at), CONST.FORMAT_DATE),
                role: item.user.role,
              }));
        
            this.pagination = {
                currentPage: listTeacher.data.data.current_page,
                total: listTeacher.data.data.total,
                perPage: listTeacher.data.data.per_page,
            };
        },
        async apiCreateTeacher(data: FormTeacher){
            const res = await api.post(ApiConstant.CREATE_TEACHER,data);
            await this.getListTeacher();
            return res
        },
        async getTeacherDetail(id: number) {
            const response = await api.get<any>(ApiConstant.GET_DETAIL_TEACHER(id));
            //this.formTeacher.email = response.data.teacher.user.email;
            const data = {
                ...response.data.data.teacher,
                email: response.data.data.teacher.user.email,
                first_name: response.data.data.teacher.user.first_name,
                last_name: response.data.data.teacher.user.last_name,
                status: response.data.data.teacher.user.status,
                gender: response.data.data.teacher.gender == "male" ? 1 : response.data.data.teacher.gender == "female" ? 2 : 3
              };              
            this.formTeacher = data;
            console.log(data)
        },
        async apiUpdateTeacher(data: FormTeacher , id: number) {
            const res = await api.put(ApiConstant.UPDATE_TEACHER(id), data);
            await this.getListTeacher();
            console.log(res);
            return res;
        },
    }
})