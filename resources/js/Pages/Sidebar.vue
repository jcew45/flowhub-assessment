<script setup>
    import { ref, watch } from 'vue';
    import PanelMenu from 'primevue/panelmenu';
    import logo from '@/images/logo.png'
    import postIcon from '@/images/post_icon.png'
    import { useRoute } from 'vue-router';


    const route = useRoute();    

    watch(route, () => {
        const currentPath = route.path;

        // Split the route path into segments
        const segments = currentPath.split('/');
    })
    
    const expandedKeys = ref("/post");
    const isLinkActive = (currentLink) => {
        if(expandedKeys.value[currentLink]) {
            return true
        }
        else {
            return false
        }
    };

    const items = ref([{
        key: "/post",
        label: 'Posts',
        icon: postIcon,
        route: '/post',
        items: [
            {
                key: "/post/add",
                label: 'Add Post',
                route: '/post/add'
            },
        ]
    }])
</script>

<template>
    <div class="sidebar">
        <div class="sidebar-head">
            <img :src="logo" alt="flowhub logo">
        </div>
        <PanelMenu :model="items" class="menu" v-model:expandedKeys="expandedKeys">
            <template #item="{ item }">
                <router-link class="flex cursor-pointer text-color px-3 py-2 link-item" :to="item.route">
                    <div>
                        <img :src="item.icon" alt="">
                        <span class="ml-2">{{ item.label }}</span>
                    </div>
                    <span v-if="item.items" :class="isLinkActive(item.route) ? 'pi pi-angle-down text-primary ml-auto arrow active' : 'pi pi-angle-down text-primary ml-auto arrow'" />
                </router-link>
            </template>
        </PanelMenu>
    </div>
</template>


<style lang="scss">
.sidebar {
    background-color: #ffffff;
    width: 16.5em;
    min-height: 100vh;
    .sidebar-head {
        padding: 20px;
    }
    .menu {
        padding: 24px 18px;
    }
    .link-item {
        justify-content: space-between;
        padding: 4px 12px;
        .arrow {
            transform: translate(0,4px) rotate(0deg);
            transition: .3s;
            &.active {
                transform: translate(0,-4px) rotate(-180deg);
    
            }
        }
    }
}
</style>