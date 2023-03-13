<template>
  <div>
        <TitleCommon :title="t('page.userCreate')" />
        <FormInfo ref="formInfo" @submit="handleSubmit" @cancel="handleBack"/>
        <Popup
            ref="modal"
            :labelCancel="t('common.no')"
            :labelOk="t('common.yes')"
            :header="t('common.confirm')"
            :content="t('common.popupConfirmSaveContent')"
            :ok="createUser"
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
    const router = useRouter();
    const modal = ref<InstanceType<typeof Popup> | null>(null);
    const formInfo = ref<InstanceType<typeof FormInfo> | null>(null);

    const createUser = async () => {
        const data = storeUser.getFormUser;
        console.log(data);
        try {
            const res = await storeUser.apiCreateUser(data);
            toast.add({group: "message", severity: "success", summary: res.data.message, life: CONST.TIME_DELAY, closable: false});
            closeModal();
            router.push({path: PAGE_ROUTE.USER_LIST});
        } catch (e:any) {
            closeModal();
        }
    };
    const resetForm = ()  => {
        formInfo.value?.handleResetForm();
    }
    const handleSubmit = () => {
        modal.value?.open();
    };
    const handleBack = () => {
        router.push({path: PAGE_ROUTE.USER_LIST})
    };
    const closeModal = () => {
        modal.value?.close();
    };
    onMounted(async () => {
        resetForm();
        console.log(storeUser.getFormUser)
    });

</script>

<style>

</style>