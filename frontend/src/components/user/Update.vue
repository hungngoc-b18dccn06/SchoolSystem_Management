<template>
    <div>
        <TitleCommon :title="t('page.userUpdate')" />
        <FormInfo @submit="handleSubmit" @cancel="handleBack"/>
        <Popup
            ref="modal"
            :labelCancel="t('common.no')"
            :labelOk="t('common.yes')"
            :header="t('common.confirm')"
            :content="t('common.popupConfirmSaveContent')"
            :ok="updateUser"
            :cancel="closeModal"
        ></Popup>
    </div>
</template>
<script setup lang="ts">
    import TitleCommon from "@/components/common/TitleCommon.vue";
    import FormInfo from '@/components/user/FormInfo.vue'
    import {useUserStore} from "@/stores/user";
    import CONST, {DEFAULT} from "@/const";
    import PAGE_ROUTE from "@/const/pageRoute";
    import {useToast} from "primevue/usetoast";
    import {onMounted, ref} from "vue";
    import Popup from "@/components/PopupConfirm.vue";
    import {useRoute, useRouter} from 'vue-router';
    import { useI18n } from "vue-i18n";

    const { t } = useI18n();
    const storeUser = useUserStore();
    const toast = useToast();
    const modal = ref<InstanceType<typeof Popup> | null>(null);
    const currentRoute = useRoute();
    const router = useRouter();

    const idUser = Number(currentRoute.params.id);

    onMounted(async () => {
        await storeUser.getUserDetail(idUser);
    });
    const handleSubmit = () => {
        modal.value?.open();
    };
    const handleBack = () => {
        router.push({path: PAGE_ROUTE.USER_LIST})
    };
    const closeModal = () => {
        modal.value?.close();
    };
    const updateUser = async () =>{
        try {
            const data = storeUser.getFormUser;
            console.log(data)
            closeModal();
            const res = await storeUser.apiUpdateUser(data, idUser )
            toast.add({group: "message", severity: "success", summary: res.data.message, life: CONST.TIME_DELAY, closable: false});
            await storeUser.apiUpdateUser(data, idUser )
            router.push({path: PAGE_ROUTE.USER_LIST});
        } catch (e:any) {
            closeModal();
        }
    }
</script>

<style>

</style>