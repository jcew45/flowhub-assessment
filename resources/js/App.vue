<template>
    <nav class="layout">
        <Sidebar/>
        <div>
            <Header/>
            <router-view v-slot="{ Component, route }">
                <div :key="route.name">
                    <!-- page title -->
                    <div class="page-title">
                        {{ route.name }}
                    </div>
                    <!-- breadcrumb -->
                    <Breadcrumb :home="home" :model="breadCrumbItems" />
                    <!-- route page content -->
                    <Component :is="Component" @assignBreadCrumbs="assignBreadCrumbs" />
                </div>
            </router-view>
        </div>
    </nav>
</template>

<script setup>
import Header from './Pages/Header.vue';
import Sidebar from './Pages/Sidebar.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref } from 'vue';

const home = ref({
    label: 'Dashboard'
});

const breadCrumbItems = ref([{label:"home"}])
const assignBreadCrumbs = (list) => {
    breadCrumbItems.value = list
}
</script>

<style lang="scss">
.layout {
    display: grid;
    grid-template-columns: 16.5em 1fr;
    .p-breadcrumb {
        background: rgba($color: #000000, $alpha: 0);
    }
    .page-title {
        margin-top: 32px;
        margin-left: 16px;
        margin-bottom: 16px;
    }
}
</style>