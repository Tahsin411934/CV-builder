<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router"; // Import useRoute to access route parameters
import axios from "axios"; // Import axios

const userData = ref(null);
const paymentData = ref(null); // To store the fetched payment data
const loading = ref(true); // To handle loading state
const error = ref(null); // To handle errors
const route = useRoute(); // Get the route object

// Function to format date as "12 March 2025"
const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { day: "numeric", month: "long", year: "numeric" };
    return date.toLocaleDateString("en-US", options);
};

onMounted(async () => {
    // Check local storage for payment submission status
    const storedData = localStorage.getItem("paymentSubmitted");
    userData.value = storedData === "true"; 
    const user = JSON.parse(localStorage.getItem("user"));

    try {
        // Fetch payment data using the user's email
        const response = await axios.get(`/api/payments/${user.email}`);
        paymentData.value = response.data; 
    } catch (err) {
        error.value = err.message || "Failed to fetch payment data"; 
    } finally {
        loading.value = false; 
    }
});
</script>

<template>
    <div class="container mt-5 min-vh-100">
        <!-- Display success message if payment data is found -->
        <div v-if="paymentData" class="text-success text-center fw-bold">
            <h3>Payment Success</h3>
            <p>Your order has been successfully placed! Our admin team will review your payment status. Once verified, our team will confirm your order via mobile SMS. If you have any questions, feel free to contact our support team.</p>
        </div>

        <!-- Display "No payment data found" or "Please pay first" if no payment data is found -->
        <div v-else class="text-danger text-center">
            <h3>No Payment Data Found</h3>
            <p>Please complete your payment to proceed.</p>
        </div>

        <!-- Loading state -->
        <div v-if="loading" class="text-center mt-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading payment details...</p>
        </div>

        <!-- Error state -->
        <!-- <div v-else-if="error" class="alert alert-danger mt-4">
            Error: {{ error }}
        </div> -->

        <!-- Display payment details if payment data is found -->
        <div v-else-if="paymentData" class="mt-4">
            <h3>Payment Details:</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Transaction Number</th>
                        <th scope="col">Uploaded Screenshot</th>
                        <th scope="col">Verification Status</th>
                        <th scope="col">Order Created at</th>
                        <th scope="col">Your Upgrated Cv</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ paymentData.id }}</td>
                        <td>{{ paymentData.method }}</td>
                        <td>{{ paymentData.transaction_number }}</td>
                        <td>
                            <img :src="paymentData.upload_ss" alt="Screenshot" class="img-fluid" style="max-width: 150px;" />
                        </td>
                        <td>{{ paymentData.verify || "Not Verified" }}</td>
                        <td>{{ formatDate(paymentData.created_at) }}</td>
                        <td>
                        <a
                            :href="`http://127.0.0.1:8000/storage/${paymentData?.updated_cv}`"
                            v-if="paymentData.updated_cv"
                        >
                            Download CV
                        </a>
                        <span v-else>Here You found your Upgrated CV</span>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
/* Custom styles if needed */
</style>