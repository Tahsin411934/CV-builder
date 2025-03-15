<template>
    <div class="container mt-5">
        <h1 class="mb-4">Orders</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>User Email</th>
                    <th>Payment Method</th>
                    <th>Transaction Number</th>
                    <th>Screenshot</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Verified</th>
                    <th>Updated CV</th>
                    <th>Upload Upgraded CV</th>
                    <th>See Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in orders" :key="order.id">
                    <td>{{ order.id }}</td>
                    <td>{{ order.user_email }}</td>
                    <td>{{ order.method }}</td>
                    <td>{{ order.transaction_number }}</td>
                    <td>
                        <img
                            :src="order.upload_ss"
                            alt="Screenshot"
                            style="width: 100px; height: auto"
                            v-if="order.upload_ss"
                        />
                        <span v-else>No Screenshot</span>
                    </td>
                    <td>{{ formatDate(order.created_at) }}</td>
                    <td>{{ formatDate(order.updated_at) }}</td>
                    <td>
                        <span
                            :class="{
                                'text-success': order.verify === 'yes',
                                'text-danger':
                                    order.verify === 'no' ||
                                    order.verify === 'cancel',
                                'text-warning': order.verify === 'delivered',
                            }"
                        >
                            {{ order.verify }}
                        </span>
                    </td>
                    <td>
                        <a
                            :href="`http://127.0.0.1:8000/storage/${order.updated_cv}`"
                            v-if="order.updated_cv"
                        >
                            Download CV
                        </a>
                        <span v-else>No CV</span>
                    </td>
                    <td>
                        <input
                            type="file"
                            @change="handleFileUpload(order, $event)"
                            class="form-control"
                            accept=".pdf,.doc,.docx"
                        />
                        <button
                            class="btn btn-secondary btn-sm mt-2"
                            :disabled="!order.newCvFile"
                            @click="saveUploadedCv(order)"
                        >
                            Save
                        </button>
                    </td>
                    <td>
                        <router-link
                            style="background: #388e3c"
                            :to="
                                order.user_email
                                    ? `/cv-details/${order.user_email}`
                                    : '/'
                            "
                            class="text-white btn btn-sm d-none d-md-block text-decoration-none mx-3 fw-medium hover-link px-4"
                        >
                            Details
                        </router-link>
                    </td>
                    <td>
                        <!-- Show Verify Button if verify is 'no' -->
                        <button
                            v-if="order.verify === 'no'"
                            class="btn btn-success btn-sm"
                            @click="verifyOrder(order)"
                        >
                            Verify
                        </button>

                        <!-- Show Deliver Button if verify is 'yes' and not delivered -->
                        <button
                            v-else-if="
                                order.verify === 'yes' && !order.delivered
                            "
                            class="btn btn-primary btn-sm"
                            @click="deliverOrder(order)"
                        >
                            Deliver
                        </button>

                        <!-- Show Cancel Button if verify is 'yes' or 'no' -->
                        <button
                            v-if="
                                order.verify === 'yes' || order.verify === 'no'
                            "
                            class="btn btn-warning btn-sm"
                            @click="cancelOrder(order)"
                        >
                            Cancel
                        </button>

                        <!-- Show Delete Button if verify is 'delivered' or 'cancel' -->
                        <button
                            v-if="
                                order.verify === 'delivered' ||
                                order.verify === 'cancel'
                            "
                            class="btn btn-danger btn-sm"
                            @click="deleteOrder(order)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            orders: [],
        };
    },
    methods: {
        async fetchUsers() {
            try {
                const response = await axios.get("/api/payments");
                this.orders = response.data.map((order) => ({
                    ...order,
                    delivered: order.verify === "yes" && order.delivered, // Add delivered flag
                    newCvFile: null, // Track new CV file
                }));
                console.log(response.data);
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleString();
        },
        async verifyOrder(order) {
            try {
                const response = await axios.put(`/api/payments/${order.id}`, {
                    verify: "yes",
                });
                order.verify = "yes"; // Update local state
                console.log("Order verified:", response.data);
            } catch (error) {
                console.error("Error verifying order:", error);
            }
        },
        async deliverOrder(order) {
            try {
                const response = await axios.put(`/api/payments/${order.id}`, {
                    verify: "delivered",
                });
                order.verify = "delivered"; // Update local state
                order.delivered = true; // Update local state
                console.log("Order delivered:", response.data);
            } catch (error) {
                console.error("Error delivering order:", error);
            }
        },
        async cancelOrder(order) {
            try {
                const response = await axios.put(`/api/payments/${order.id}`, {
                    verify: "cancel",
                });
                order.verify = "cancel"; // Update local state
                console.log("Order canceled:", response.data);
            } catch (error) {
                console.error("Error canceling order:", error);
            }
        },
        async deleteOrder(order) {
            try {
                const response = await axios.delete(
                    `/api/payments/${order.id}`
                );
                this.orders = this.orders.filter((o) => o.id !== order.id); // Remove from local state
                console.log("Order deleted:", response.data);
            } catch (error) {
                console.error("Error deleting order:", error);
            }
        },
        handleFileUpload(order, event) {
            const file = event.target.files[0];
            if (file) {
                order.newCvFile = file; // Store the file in the order object
            }
        },
        async saveUploadedCv(order) {
            if (!order.newCvFile) return;

            const formData = new FormData();
            formData.append("updated_cv", order.newCvFile); // Ensure the key matches what the backend expects

            try {
                const response = await axios.post(
                    `/api/payments/upload-upgraded-cv/${order.id}`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data", // Ensure the correct content type
                        },
                    }
                );

                // Update the order with the new CV file URL
                order.updated_cv = response.data.fileUrl;
                order.newCvFile = null; // Reset the new file
                await this.fetchUsers();
                console.log("File uploaded:", response.data);
            } catch (error) {
                console.error("Error uploading file:", error);
            }
        },
    },
    created() {
        this.fetchUsers();
    },
};
</script>

<style scoped>
.container {
    max-width: 1200px;
    margin: 0 auto;
}

.table {
    width: 100%;
    margin-top: 20px;
}

.text-success {
    color: green;
}

.text-danger {
    color: red;
}

.text-warning {
    color: orange;
}

.btn-sm {
    margin: 2px;
}
</style>
