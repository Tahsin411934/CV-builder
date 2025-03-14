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

    // Get the paymentId from the route parameters
    const paymentId = route.params.paymentId;

    try {
        // Fetch payment data using the paymentId from the route
        const response = await axios.get(`/api/payments/${paymentId}`);
        paymentData.value = response.data; 
    } catch (err) {
        error.value = err.message || "Failed to fetch payment data"; 
    } finally {
        loading.value = false; 
    }
});
</script>

<template>
    <div class="container mt-5">
        
        <span v-if="userData" class="text-success text-center fw-bold"><h3>
            Payment success
        </h3> 
    <p>" Your order has been successfully placed!. Our admin team will review your payment status. Once verified, our team will confirm your order via mobile SMS. If you have any questions, feel free to contact our support team."</p>
    </span>
        <span v-else class="text-danger">Please pay first</span>

        <!-- Display fetched payment data -->
        <div v-if="loading" class="text-center mt-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading payment details...</p>
        </div>
        <div v-else-if="error" class="alert alert-danger mt-4">
            Error: {{ error }}
        </div>
        <div v-else-if="paymentData || userData" class="mt-4">
            <h3>Payment Details:</h3>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <th scope="row">Payment Method</th>
                        <th scope="row">Transaction Number</th>
                        <th scope="row">Uploaded Screenshot</th>
                        <th scope="row">Verification Status</th>
                        <th scope="row">Order Created at</th>
                        
                    </tr>
                    <tr>
                        <td>{{ paymentData.id }}</td>
                        <td>{{ paymentData.method }}</td>
                        <td>{{ paymentData.transaction_number }}</td>
                        <td>
                            <img :src="paymentData.upload_ss" alt="Screenshot" class="img-fluid" style="max-width: 150px;" />
                        </td>
                       
                        
                        <td>{{ paymentData.verify || "Not Verified" }}</td>
                        <td>{{ formatDate(paymentData.created_at) }}</td>
                
                        
                    </tr>
                   
                   
                    
                </tbody>
            </table>
        </div>
        <div v-else class="alert alert-warning mt-4">
            No payment data found.
        </div>
    </div>
</template>

<style scoped>
/* Custom styles if needed */
</style>