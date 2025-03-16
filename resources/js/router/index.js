import { createRouter, createWebHistory } from "vue-router";

// Define your routes
const routes = [
    {
        path: "/",
        name: "Home",
        component: () => import("../Pages/Home.vue"), // Lazy-loaded
    },
    {
        path: "/createTest",
        name: "About",
        component: () => import("../Pages/CreateTest.vue"), // Lazy-loaded
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
        path: "/premiumcv/select-tamplate",
        name: "premiumcv",
        component: () => import("../Pages/PremiumCV/tamplate.vue"), // Lazy-loaded
        meta: { requiresAuth: true },
    },
    {
        path: "/premiumcv/pdf-upload/:templateId",
        name: "pdfUpload",
        component: () => import("../Pages/PremiumCV/pdfUpload.vue"), // Lazy-loaded
        meta: { requiresAuth: true },
    },
    {
        path: "/premiumcv/payment/:templateId",
        name: "pdfUploadpayment",
        component: () => import("../Pages/PremiumCV/Payment.vue"), // Lazy-loaded
        meta: { requiresAuth: true },
    },
    {
        path: "/premiumcv/overview",
        name: "premiumcvOverview",
        component: () => import("../Pages/PremiumCV/overview.vue"), // Lazy-loaded
        meta: { requiresAuth: true },
    },
    {
        path: "/premiumcv/create/:templateId",
        name: "templateId",
        component: () => import("../Pages/PremiumCV/create.vue"), // Lazy-loaded
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
                
                component: () => import("../Pages/Resume/Overview.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "/heading",
                
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
                component: () =>
                    import("../pages/Resume/LanguageProficiencyForm.vue"), // Lazy-loaded
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
    {
        path: "/confirm-order",
        name: "confirmOrder",
        component: () => import("../Pages/PremiumCV/confirmOrder.vue"),

        meta: { requiresAuth: true },
    },
    {
        path: "/myorders",
        name: "MyOrders",
        component: () => import("../Pages/PremiumCV/order.vue"),

        meta: { requiresAuth: true },
    },
    {
        path: "/cv-details/:email",
        name: "cv-details",
        component: () => import("../Pages/dashboard/cv-details.vue"),

        meta: { requiresAuth: true },
    },
    

    {
        path: "/dashboard",
        component: () => import("../Pages/dashboard/Dashboard.vue"),
        children: [
            {
                path: "manage-tamplate",
                component: () =>
                    import(
                        /* webpackChunkName: "overview" */ "../Pages/dashboard/CvTemplateTable.vue"
                    ),
            },
            {
                path: "orders",
                component: () => import("../Pages/dashboard/Orders/order.vue"),
        
                meta: { requiresAuth: true },
            },
        ],
    },
    {
        path: "/",
        redirect: "/dashboard/overview", // Redirect to dashboard by default
    },
    {
        path: "/premiumcv/:id",
        component: () => import("../Pages/PremiumCV/Layout.vue"),
        children: [
            {
                path: "objective",
               
                component: () => import("../pages/Resume/ObjectiveForm.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "heading",
                
                component: () => import("../Pages/Resume/Heading.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "education",
                component: () => import("../Pages/Resume/Eduction.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "experience",
                
                component: () => import("../pages/Resume/ExperienceForm.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            
            {
                path: "finalize",
               
                component: () => import("../Pages/PremiumCV/Summary.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "instruction",
               
                component: () => import("../Pages/PremiumCV/Instruction.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "skills",
               
                component: () => import("../pages/Resume/Skills.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "language-proficiency",
               
                component: () =>
                    import("../pages/Resume/LanguageProficiencyForm.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "project",
                component: () => import("../pages/Resume/Projects.vue"), // Lazy-loaded
                meta: { requiresAuth: true },
            },
            {
                path: "payment",
                component: () => import("../Pages/PremiumCV/Payment.vue"),

                meta: { requiresAuth: true },
            },
            {
                path: "confirm-order",
                component: () => import("../Pages/PremiumCV/confirmOrder.vue"),

                meta: { requiresAuth: true },
            },
        ],
    },
    {
        path: "/",
        redirect: "/premiumcv/:id/objective", // Redirect to dashboard by default
    },
];

// Create the router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return {
            top: 0,
            behavior: "smooth", // মসৃণ স্ক্রল
        };
    },
});

export default router;
