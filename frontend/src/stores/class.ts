import {defineStore} from "pinia";
import api from "@/api";
import {format} from "date-fns";
import CONST, {ApiConstant, DEFAULT} from "@/const";
import axios from "axios";
import { da } from "date-fns/locale";
export interface  Class {
    id?: number,
    teacher_id: string;
    class_numeric: string;
    class_name:string;
    class_description?: string;
    students_count?: string;
}
export interface ParamsSearch {
    search_text?: string;
}
export interface Pagination {
    currentPage: number,
    total: number,
    perPage: number
}
interface FormClass {
   class_name?: string;
   class_numeric?:string;
   class_description?:string;
   teacher_name?:any;
   teacher_id?: number;
}
interface UserStore {
    classes: Class[],
    paramSearch: ParamsSearch,
    formClass: FormClass,
    pagination: Pagination,
}
export const useClassStore = defineStore({
    id: "class",
    state: (): UserStore =>{
        return {
            classes: [],
            paramSearch: {},
            formClass: {
                class_name: '',
                class_description: '',
                class_numeric: '',
                teacher_name: '',
                teacher_id: 0
            },
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
        getClasses: (state => state.classes),
        getFormClass: (state => state.formClass)
    },
    actions:{
        async getListClass(page?: number) {
            const listClass = await api.get(ApiConstant.GET_CLASS, {
                params: {
                  page: page ?? 1,
                  ...this.paramSearch
                }
              });
            this.classes = listClass.data.data.classes.map((item:any) => ({
                ...item,
                teacher: item.user.first_name + ' ' + item.user.last_name
            }));
            this.pagination = {
                currentPage: listClass.data.data.page,
                total: listClass.data.data.count,
                perPage: listClass.data.data.linePerPage,
            };
        },

        async apiCreateNewClass(data: FormClass){
            const res = await api.post(ApiConstant.CREATE_NEW_CLASS,data);
            await this.getListClass();
            return res
        },
    }
})