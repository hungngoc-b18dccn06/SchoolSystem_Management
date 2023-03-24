import {defineStore} from "pinia";
import api from "@/api";
import {ApiConstant} from "@/const";
interface CategoryStore {
    categories: CategoryDetail[];
}
export interface CategoryDetail {
    id?: number,
    name: string,
    display_order: number,
    category?: string,
    status?: number,
}
export interface CategoryForm {
    categories: CategoryDetail,
}

export const useCategoryStore = defineStore({
    id: "category",
    state: (): CategoryStore =>{
        return {
            categories: [],
        }
    },
    getters:{
        getCategoryList: (state => state.categories)
    },
    actions:{
        async apiGetCategories() {
            const res = await api.get(ApiConstant.GET_LIST_CATEGORY);
            this.categories = res.data.data.sort((a: CategoryDetail, b: CategoryDetail) => (a.display_order - b.display_order));

        },
        async apiUpdateCategories(data: CategoryForm) {
            const res = await api.post(ApiConstant.UPDATE_CATEGORY, data);
            await this.apiGetCategories();
            return res;
        },

        async setCategoryList(data: CategoryDetail[]) {
            this.categories = data;
        },

        async apiDeleteCategories($id: number) {
            const res = await api.delete<any>(ApiConstant.DELETE_CATEGORY($id));
            // await this.apiGetCategories();
            return res;
        },
    }

})