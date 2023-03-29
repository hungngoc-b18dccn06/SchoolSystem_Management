<template>
    <div>
        <TitleCommon :title="t('page.userCreate')" />
        <DataTable
                :value="storeUser.getUsers"
                class="p-datatable-sm"
                ref="dt"
                @row-click="gotToDetail($event)"
                :rowHover="true"
                responsive-layout="scroll">
             <Column style="padding-left:2rem; margin:auto" v-for="col in columns" :key="col.field" :field="col.field" :header="col.header" :sortable="true" ></Column>
                <Column headerStyle=" text-align: center" bodyStyle="text-align: center; overflow: visible">
                    <template #body="slotProps">
                        <Button class="p-button-danger p-button-sm white-space-nowrap" icon="pi pi-trash" v-if="slotProps.data.email !== storeUser.getProfile.email" @click="deleteUser(slotProps.data.id)" :label="t('common.delete')"></Button>
                    </template>
                </Column>
                <template #empty>
                    <div class="text-center">{{ $t('user.userNotFound') }}</div>
                </template>
                <template #loading>
                    {{ $t('user.userLoading') }}
                </template>
            <template #header>
                    <div class="flex justify-content-between align-items-center">
                        <span class="p-input-icon-left w-5">
                            <i class="pi pi-search"></i>
                            <InputText class="w-full" :placeholder="$t('common.search')" />
                        </span>
                        <div>
                            <Button
                                class="white-space-nowrap"
                                @click="gotToCreate"
                                icon="pi pi-plus"
                                :label="t('user.userRegister')"
                            ></Button>
                        </div>
                    </div>
                </template>
             <template #footer>
                    <Paginator
                        v-if="storeUser.getPagination.total > 0"
                        :first="(storeUser.getPagination.currentPage - 1) * storeUser.getPagination.perPage"
                        :rows="storeUser.getPagination.perPage"
                        :totalRecords="storeUser.getPagination.total"
                        template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                        :currentPageReportTemplate="AppConstant.CURRENT_PAGE_REPORT_TEMPLATE"
                        @page="changePage">
                    </Paginator>
                </template>   
        </DataTable>
        <Popup
                ref="modal"
                :labelCancel="t('common.no')"
                :labelOk="t('common.yes')"
                :header="t('common.confirm')"
                :content="t('common.popupDeleteContent')"
                :ok="confirm"
                :cancel="cancel"
            ></Popup>
    </div>
</template>
<script setup lang="ts">
    import {PrimeIcons, FilterMatchMode, FilterOperator} from 'primevue/api';
    import Paginator from 'primevue/paginator';
    import TitleCommon from "@/components/common/TitleCommon.vue"
    import Popup from "@/components/PopupConfirm.vue";
    import { useUserStore } from "@/stores/user";
    import FooterCommon from "@/components/common/FooterCommon.vue";
    import { ref, onMounted, watch } from "vue";
    import {useRoute, useRouter} from "vue-router";
    import CONST, {AppConstant} from "@/const";
    import {useToast} from "primevue/usetoast";
    import { useI18n } from "vue-i18n";
    import {number} from "yup";
    const router = useRouter();
    const storeUser = useUserStore();
    const totalRecords = ref();
    const idUser = ref(0);
    const toast = useToast();
    const {t} = useI18n();
    const columns = [
        {field: 'id', header: 'ID'},
        {field: 'name', header: '氏名' },
        {field: 'email', header: 'メールアドレス'},
        {field: 'role', header: '権限設定'},
        {field: 'created_at', header: '登録日'},
        {field: 'status', header: '状態'},
    ];
    function gotToDetail(event : object){
        router.push(`/user/${event.data.id}/update`);
    }
    const gotToCreate = () =>{
        router.push(`/user/create`);
    }
    const filters = ref({
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    });
    const modal = ref<InstanceType<typeof Popup> | null>(null);
    const openModal = () => {
        modal.value?.open();
    };
    const closeModal = () => {
        modal.value?.close();
    };
    const deleteUser = (event:any) =>{
        idUser.value = event;
        modal.value?.open();
    };
     const changePage = async (event: any) => {
        storeUser.getListUser(event.page + 1);
    };
    const confirm = async () =>{
        try {
            closeModal();
            const res = await storeUser.deleteUser(idUser.value);
            toast.add({group: "message", severity: "success", summary: res.data.message, life: CONST.TIME_DELAY,  closable: false});
        } catch (e) {
            console.log(e);
            closeModal();
        }
    }
    const cancel = () => {
        closeModal();
    }
    watch(
        () => storeUser.getParamSearch.search_text,
        (value) => {
            setTimeout(function () {
                if (value === storeUser.getParamSearch.search_text) {
                    storeUser.getListUser();
                }
            }, 1000);
        }
    );
    onMounted(
        () => {
            storeUser.getListUser();
            storeUser.getProfileDetail();
        }
    )
</script>
<style scoped>
    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .product-image {
        width: 50px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    }
    h5.m-0 {
        font-size: 26px;
        font-weight: 600;
    }

</style>
