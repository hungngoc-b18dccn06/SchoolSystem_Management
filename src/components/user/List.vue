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
        </DataTable>
    </div>
</template>
<script setup lang="ts">
    import {PrimeIcons} from 'primevue/api';
    import { ref, onMounted } from "vue";
    import { useRouter } from "vue-router";
    import { useUserStore } from "@/stores/user";
    import TitleCommon from "@/components/common/TitleCommon.vue"
    import { useI18n } from "vue-i18n";
    const router = useRouter();
    const storeUser = useUserStore();
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
    onMounted(
        () => {
            storeUser.getListUser();
            console.log(11)
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
