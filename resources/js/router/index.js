import { createRouter, createWebHistory } from "vue-router";

// Define your routes
const routes = [
    {
        path: "/",
        name: "Home",
        component: () => import("../Pages/Home.vue"), // Lazy-loaded
    },
    {
        path: "/about",
        name: "About",
        component: () => import("../components/About.vue"), // Lazy-loaded
    },
    {
        path: "/register",
        name: "Register",
        component: () => import("../components/Auth/Registration.vue"), // Lazy-loaded
    },
    {
        path: "/login",
        name: "Login",
        component: () => import("../components/Auth/LoginForm.vue"), // Lazy-loaded
    },
    {
        path: "/resume",
        name: "Resume",
        component: () => import("../Pages/Resume/Resume.vue"), // Lazy-loaded
        children: [
            {
                path: "/resume/overview",
                name: "Overview",
                component: () => import("../Pages/Resume/Overview.vue"), // Lazy-loaded
            },
            {
                path: "/heading",
                name: "Heading",
                component: () => import("../Pages/Resume/Heading.vue"), // Lazy-loaded
            },
            {
                path: "/education",
                name: "Education",
                component: () => import("../Pages/Resume/Eduction.vue"), // Lazy-loaded
            },
            {
                path: "/experience",
                name: "Test",
                component: () => import("../components/AddTest.vue"), // Lazy-loaded
            },
        ],
    },
    
];

// Create the router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
