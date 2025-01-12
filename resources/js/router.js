import { createRouter, createWebHistory } from "vue-router";

import Home from './Pages/Home.vue'
import Installations from "./Pages/Installations.vue";

const routes = [
    {
        path: "/",
        name: 'home',
        component: Home
    },
    {
        path: "/installations",
        name: 'installations',
        component: Installations
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// In the future add route guards here getting user data from the store

export default router;
