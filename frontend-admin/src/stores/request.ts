import type {AxiosError} from "axios";
import {defineStore} from "pinia";
interface OwnState {
  isFetching: boolean[];
  error?: AxiosError;
}
export const useRequestStore = defineStore({
  id: "request",
  state: (): OwnState => ({
    isFetching: [] as boolean[],
    error: undefined,
  }),
  getters: {
    getIsFetcing: (state) => state.isFetching,
  },
  actions: {
    insert() {
      this.isFetching.push(true);
    },
    remove() {
      this.isFetching.pop();
    },
    resetError() {
      this.error = undefined;
    },
    setError(value: AxiosError) {
      this.error = value;
    },
  },
});
