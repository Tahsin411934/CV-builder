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
        meta: { requiresAuth: true },
    },
    {
        path: "/services",
        name: "services",
        component: () => import("../components/Home/Services.vue"), // Lazy-loaded
       
    },
    {
        path: "/premiumcv",
        name: "premiumcv",
        component: () => import("../components/premiumcv.vue"), // Lazy-loaded
        meta: { requiresAuth: true },
    },
    {
        path: "/profile",
        name: "profile",
        component: () => import("../components/UserProfile.vue"), // Lazy-loaded
        meta: { requiresAuth: true },
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
                path: "/resume/finalize",
                name: "Summary",
                component: () => import("../Pages/Resume/Summary.vue"), // Lazy-loaded
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
            {

                path: "/project",
                name: "Projects",
                component: () => import("../pages/Resume/Projects.vue"), // Lazy-loaded
            },
            {

                path: "/resume/PDF",
                name: "PDF",
                component: () => import("../Pages/Resume/PDF.vue"), // Lazy-loaded
            },
        ],
    },
    
];

// Create the router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return {
          top: 0,
          behavior: 'smooth', // মসৃণ স্ক্রল
        };
      },
});

export default router;
