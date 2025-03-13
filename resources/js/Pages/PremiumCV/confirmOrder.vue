<script setup>
import { ref, onMounted } from "vue";
import axios from "axios"; // Import axios

const userData = ref(null);
const paymentData = ref(null); // To store the fetched payment data
const loading = ref(true); // To handle loading state
const error = ref(null); // To handle errors

onMounted(async () => {
    // Check local storage for payment submission status
    const storedData = localStorage.getItem("paymentSubmitted");
    userData.value = storedData === "true"; // Convert to boolean

    // Fetch payment data from the API using axios
    try {
        const response = await axios.get("/api/payments/1");
        paymentData.value = response.data; // Store the fetched data
    } catch (err) {
        error.value = err.message || "Failed to fetch payment data"; // Handle errors
    } finally {
        loading.value = false; // Set loading to false after the request completes
    }
});
</script>

<template>
    <div>
        This is the confirm order page 
        <span v-if="userData">Payment success</span>
        <span v-else>Please pay fast</span>

        <!-- Display fetched payment data -->
        <div v-if="loading">
            Loading payment details...
        </div>
        <div v-else-if="error">
            Error: {{ error }}
        </div>
        <div v-else-if="paymentData">
            <h3>Payment Details:</h3>
            <p>ID: {{ paymentData.id }}</p>
            <p>Amount: {{ paymentData.amount }}</p>
            <p>Status: {{ paymentData.status }}</p>
            <!-- Add more fields as needed -->
        </div>
        <div v-else>
            No payment data found.
        </div>
    </div>
</template>