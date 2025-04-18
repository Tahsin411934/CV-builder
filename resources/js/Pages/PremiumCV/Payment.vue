<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router"; // Import useRouter and useRoute

const router = useRouter(); // Initialize the router
const route = useRoute(); // Initialize the route

// Form State
const user_email = ref("");
const method = ref("");
const transaction_number = ref("");
const upload_ss = ref(null);
const loading = ref(false);
const message = ref("");
const error = ref("");
const paymentSubmitted = ref(false); // Track payment submission status

// Payment Methods with Icons
const paymentMethods = [
    { name: "Bkash", icon: "/payment/bikas.webp" }, // Path to Bkash icon
    { name: "Nagad", icon: "/payment/nagad.jpg" }, // Path to Nagad icon
    { name: "Rocket", icon: "/payment/rocket.png" }, // Path to Rocket icon
    { name: "Upay", icon: "/payment/upai.png" }, // Path to Card icon
];

// Handle File Upload
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        upload_ss.value = file;
    }
};

// Submit Payment
const submitPayment = async () => {
    error.value = "";
    message.value = "";
    loading.value = true;

    if (
        !user_email.value ||
        !method.value ||
        !transaction_number.value ||
        !upload_ss.value
    ) {
        error.value = "Please fill all fields";
        loading.value = false;
        return;
    }

    try {
        const formData = new FormData();
        formData.append("user_email", user_email.value);
        formData.append("method", method.value);
        formData.append("transaction_number", transaction_number.value);
        formData.append("upload_ss", upload_ss.value);

        const response = await axios.post("/api/payments", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        const submittedPayment = response.data;
        
        message.value = "Payment submitted successfully!";
        paymentSubmitted.value = true; // Update paymentSubmitted status
        localStorage.setItem("paymentSubmitted", "true"); // Store payment status in localStorage

        // Reset form fields
        user_email.value = "";
        method.value = "";
        transaction_number.value = "";
        upload_ss.value = null;

        // Redirect to the Confirm Order route after successful payment
        const templateId = route.params.id; // Get templateId from the current route
        console.log(templateId);
        if (templateId) {
            router.push(`/premiumcv/${templateId}/confirm-order`);
        } else {
            router.push(`/confirm-order`);
        }
         // Navigate to the Confirm Order route
    } catch (err) {
        error.value = "Failed to process payment. Try again.";
    } finally {
        loading.value = false;
    }
};

// Retrieve user email and payment status from local storage when the component is mounted
onMounted(() => {
    const user = JSON.parse(localStorage.getItem("user"));
    if (user && user.email) {
        user_email.value = user.email;
    }

    // Check if payment was previously submitted
    const paymentStatus = localStorage.getItem("paymentSubmitted");
    if (paymentStatus === "true") {
        paymentSubmitted.value = true;
    }
});
</script>

<template>
    <div
        class="container d-flex justify-content-center align-items-center min-vh-100"
    >
        <div class="card p-4" style="width: 100%; max-width: 500px">
            <h2 class="text-center mb-4 fw-bold">Premium CV Payment</h2>

            <!-- Success Message -->
            <div v-if="message" class="alert alert-success text-center">
                {{ message }}
            </div>

            <!-- Error Message -->
            <div v-if="error" class="alert alert-danger text-center">
                {{ error }}
            </div>

            <form @submit.prevent="submitPayment">
                <!-- Email (Hidden) -->
                <div class="mb-3 d-none">
                    <label for="user_email" class="form-label">Email</label>
                    <input
                        type="email"
                        v-model="user_email"
                        class="form-control"
                        id="user_email"
                        required
                    />
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <div class="d-flex flex-wrap gap-2">
                        <div
                            v-for="pm in paymentMethods"
                            :key="pm.name"
                            class="flex-grow-1 text-center p-3 border rounded cursor-pointer"
                            :class="{
                                'bg-primary text-white': method === pm.name,
                            }"
                            @click="method = pm.name"
                        >
                            <img
                                :src="pm.icon"
                                :alt="pm.name"
                                class="img-fluid mb-2"
                                style="width: 40px; height: 40px"
                            />
                            <div>{{ pm.name }}</div>
                        </div>
                    </div>
                    <input type="hidden" v-model="method" required />
                </div>

                <!-- Transaction Number -->
                <div class="mb-3">
                    <label for="transaction_number" class="form-label"
                        >Transaction Number</label
                    >
                    <input
                        type="text"
                        v-model="transaction_number"
                        class="form-control"
                        id="transaction_number"
                        required
                    />
                </div>

                <!-- Upload Screenshot -->
                <div class="mb-4">
                    <label for="upload_ss" class="form-label"
                        >Upload Screenshot</label
                    >
                    <input
                        type="file"
                        @change="handleFileUpload"
                        accept="image/*"
                        class="form-control"
                        id="upload_ss"
                        required
                    />
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="btn btn-primary w-100 py-2"
                    :disabled="loading"
                >
                    {{ loading ? "Processing..." : "Submit Payment" }}
                </button>
            </form>
        </div>
        <div class="card p-4" style="width: 100%; max-width: 500px">
            <div class="mb-3">
                <p class="text-muted text-center mb-4">
                    Use one of the following accounts to send your payment.
                </p>
                <div v-for="pm in paymentMethods" :key="pm.name" class="mb-3 text-center mx-5">
                    <div class="d-flex align-items-right gap-2">
                        <img
                            :src="pm.icon"
                            :alt="pm.name"
                            class="img-fluid"
                            style="width: 30px; height: 30px"
                        />
                        <strong>{{ pm.name }}</strong>
                    </div>
                    <div class="mt-2">
                        <span class="text-muted">Account Number:</span>
                        <span class="fw-bold">01XXXXXXXXX</span>
                        <!-- Replace with the user's account number -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Custom Styles */
.card {
    border: none;
    border-radius: 10px;
}

.cursor-pointer {
    cursor: pointer;
}

.alert {
    margin-bottom: 1rem;
}

.img-fluid {
    max-width: 100%;
    height: auto;
}
</style>
