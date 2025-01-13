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
        path: "/overview",
        name: "OverviewR",
        component: () => import("../Pages/Overview.vue"), // Lazy-loaded
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
                meta: { requiresAuth: true },
            },
            {
                path: "/heading",
                name: "Heading",
                component: () => import("../Pages/Resume/Heading.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "/education",
                name: "Education",
                component: () => import("../Pages/Resume/Eduction.vue"), // Lazy-loaded
            },
            {
                path: "/experience",
                name: "Test",
                component: () => import("../pages/Resume/ExperienceForm.vue"), // Lazy-loaded
            },
            {
                path: "/resume/objective",
                name: "Objective",
                component: () => import("../pages/Resume/ObjectiveForm.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "/resume/skills",
                name: "Skills",
                component: () => import("../pages/Resume/Skills.vue"), // Lazy-loaded
            },
            {
                path: "/resume/language-proficiency",
                name: "language-proficiency",
                component: () => import("../pages/Resume/LanguageProficiencyForm.vue"), // Lazy-loaded
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
