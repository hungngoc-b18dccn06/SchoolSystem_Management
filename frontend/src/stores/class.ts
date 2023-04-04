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

interface UserStore {
    classes: Class[],
    paramSearch: ParamsSearch,
    pagination: Pagination,
}
export const useClassStore = defineStore({
    id: "teacher",
    state: (): UserStore =>{
        return {
            classes: [],
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
        getClasses: (state => state.classes),
    },
    actions:{
        async getListClass(page?: number) {
            const listClass = await api.get(ApiConstant.GET_CLASS, {
                params: {
                  page: page ?? 1,
                  ...this.paramSearch
                }
              });
              console.log(listClass)
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
    }
})