import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("./Pages/Home.vue"),
    },
    {
        path: "/post",
        name: "Post",
        component: () => import("./Pages/Post.vue"),
    },
    {
        path: "/post/add",
        name: "Add New Post",
        component: () => import("./Pages/AddPost.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});