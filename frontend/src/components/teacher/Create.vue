<template>
  <div>
        <TitleCommon :title="t('教師を作成する')" />
        <FormInfo ref="formInfo" @submit="handleSubmit" @cancel="handleBack"/>
        <Popup
            ref="modal"
            :labelCancel="t('common.no')"
            :labelOk="t('common.yes')"
            :header="t('common.confirm')"
            :content="t('common.popupConfirmSaveContent')"
            :ok="createTeacher"
            :cancel="closeModal"
        ></Popup>
    </div>
</template>

<script setup lang="ts">
    import TitleCommon from "@/components/common/TitleCommon.vue";
    import FormInfo from '@/components/teacher/FormInfo.vue'
    import {useUserStore} from "@/stores/user";
    import CONST, {DEFAULT} from "@/const";
    import PAGE_ROUTE from "@/const/pageRoute";
    import {useToast} from "primevue/usetoast";
    import {onMounted, ref} from "vue";
    import Popup from "@/components/PopupConfirm.vue";
    import {useRoute, useRouter} from 'vue-router';
    import { useI18n } from "vue-i18n";
    import {useTeacherStore} from "@/stores/teacher";
    import {format} from "date-fns";
    const { t } = useI18n();
    const storeUser = useUserStore();
    const storeTeacher = useTeacherStore();
    const toast = useToast();
    const router = useRouter();
    const modal = ref<InstanceType<typeof Popup> | null>(null);
    const formInfo = ref<InstanceType<typeof FormInfo> | null>(null);

    const createTeacher = async () => {
         const data = {
            ...storeTeacher.getFormTeacher,
            dateofbirth: format(new Date(storeTeacher.getFormTeacher.dateofbirth), CONST.DATE_FORMAT) ,
            role: '4',
        };
        try {
            const res = await storeTeacher.apiCreateTeacher(data);
            toast.add({group: "message", severity: "success", summary: res.data.message, life: CONST.TIME_DELAY, closable: false});
            closeModal();
            router.push({path: PAGE_ROUTE.TEACHER_LIST});
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
    });

</script>

<style>

</style>