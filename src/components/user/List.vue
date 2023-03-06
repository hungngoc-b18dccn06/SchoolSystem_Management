<template>
    <div>
        <DataTable
                :value="userList"
                class="p-datatable-sm"
                ref="dt"
                @row-click="gotToDetail($event)"
                :rowHover="true"
                responsive-layout="scroll">
            <Column v-for="col in columns" :key="col.field" :field="col.field" :header="col.header" @click="gotToDetail"></Column>
            <Column headerStyle="width: 4rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
                <template #body>
                    <Button type="button" icon="pi pi-cog" @click="gotToDetail"></Button>
                </template>
            </Column>
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
            <template #empty>
                No users found.
            </template>
            <template #loading>
                Loading users data. Please wait.
            </template>
        </DataTable>
    </div>
</template>
<script setup lang="ts">
    import {PrimeIcons} from 'primevue/api';
    import { ref, onMounted } from "vue";
    import { useRouter } from "vue-router";
    const router = useRouter();
    import { useI18n } from "vue-i18n";
   
    const {t} = useI18n();
    const userList = [
        {id: 1,vin: 'admin1@gmail.com', year: '2021', brand: 'BMW', color: 'Black'},
        {id: 2,vin: 'admin1@gmail.com', year: '2022', brand: 'Mercedes', color: 'White'},
        {id: 3,vin: 'admin1@gmail.com', year: '2023', brand: 'Audi', color: 'Silver'},
    ];
    const columns = [
        {field: 'id', header: 'id'},
        {field: 'vin', header: 'Vin' },
        {field: 'year', header: 'Year'},
        {field: 'brand', header: 'Brand'},
        {field: 'color', header: 'Color'},
    ];
    function gotToDetail(event : object){
        router.push(`/user/${event.data.id}/update`);
    }
    const gotToCreate = () =>{
        console.log(11)
    }
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
