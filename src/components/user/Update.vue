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
</script>

<style>

</style>