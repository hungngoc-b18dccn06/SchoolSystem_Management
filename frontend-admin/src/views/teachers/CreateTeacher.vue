<script setup lang="ts">
    import CreateTeacher from "@/components/teacher/Create.vue";
</script>

<template>
    <CreateTeacher>
        <template #main>
            <router-view />
        </template>
    </CreateTeacher>
</template>
<style lang="scss"></style>
