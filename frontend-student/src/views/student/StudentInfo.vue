<script setup lang="ts">
    import StudentInfo from "@/components/students/Info.vue";
</script>

<template>
    <StudentInfo>
        <template #main>
            <router-view />
        </template>
    </StudentInfo>
</template>
<style lang="scss"></style>
