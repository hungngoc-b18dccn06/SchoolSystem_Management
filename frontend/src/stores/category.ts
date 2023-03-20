import {defineStore} from "pinia";
import axios from "axios";
import {ApiConstant} from "@/const";
import api from "@/api";
interface CategoryStore {
    categories: CategoryDetail[];
}
export interface CategoryDetail {
    id: number,
    name: string,
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
            const res = await api.get("http://127.0.0.1:8000" + ApiConstant.GET_LIST_CATEGORY);
            this.categories = res.data.data;
            console.log(this.categories)
        },
        async apiUpdateCategories(data: CategoryDetail) {
            const res = await axios.post("http://127.0.0.1:8000" + ApiConstant.UPDATE_CATEGORY, data, {headers: {
                Authorization: 'Bearer 799|54IAeLUQrfxLYVClLwlAcZ8ao8cs9BpKzt1YUhFv'
            }});
            await this.apiGetCategories();
        },
    }

})