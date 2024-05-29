<script setup>
    import IconField from 'primevue/iconfield';
    import InputIcon from 'primevue/inputicon';
    import InputText from 'primevue/inputtext';
    import profileImg from '@/images/profile_icon.png'
    import { ref } from 'vue';

    const searchField = ref("")
</script>

<template>
    <div class="header">
        <div class="topbar-start">
            <IconField iconPosition="left">
                <InputIcon class="pi pi-search" style="color: #0079E9"> </InputIcon>
                <InputText :class="$style.searchinput" v-model="searchField" placeholder="Search something here..." />
            </IconField>
        </div>
        <div class="topbar-end">
            <div class="profile-wrapper">
                <img :src="profileImg" alt="profile icon">
                <div class="profile-desc">
                
                </div>
            </div>
        </div>
    </div>
</template>


<style lang="scss" scoped>
.header {
    height: 58px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    border-bottom: 1px solid #E9EBF0;
    .topbar-start {
        margin-left: 34px;
    }
}
</style>

// component styles
<style module>
    .searchinput {
        background: #D1D5DB;
    }

</style>