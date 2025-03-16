<template>
    <div class="container mt-4 min-vh-100">
        <h2 class="mb-4 text-dark font-weight-bold text-center">My Orders</h2>
        <div v-for="order in sortedOrders" :key="order.id">
            <h4>{{ formatDate(order.created_at) }}</h4>

            <table class="table table-bordered table-striped table-hover mb-5">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Payment Method</th>
                        <th>Transaction Number</th>
                        <th>Screenshot</th>
                        <th>Payment Verified</th>
                        <th>Updated CV</th>
                        <th>See Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ order.id }}</td>
                        <td>{{ order.method }}</td>
                        <td>{{ order.transaction_number }}</td>
                        <td>
                            <img
                                :src="`http://your-backend-url/${order.upload_ss}`"
                                alt="Screenshot"
                                class="img-thumbnail"
                                style="max-width: 100px"
                                v-if="order.upload_ss"
                            />
                            <span v-else class="text-muted">No Screenshot</span>
                        </td>
                        <td>
                            <span
                                :class="[
                                    'badge',
                                    order.verify === 'yes'
                                        ? 'badge-success text-success'
                                        : order.verify === 'no'
                                        ? 'badge-danger text-danger'
                                        : order.verify === 'delivered'
                                        ? 'badge-primary text-primary'
                                        : order.verify === 'cancel'
                                        ? 'badge-warning text-warning'
                                        : 'badge-secondary',
                                ]"
                            >
                                {{
                                    order.verify === "yes"
                                        ? "Verified"
                                        : order.verify === "no"
                                        ? "Not Verified"
                                        : order.verify === "delivered"
                                        ? "Delivered"
                                        : order.verify === "cancel"
                                        ? "Cancelled"
                                        : "Unknown"
                                }}
                            </span>
                        </td>
                        <td>
                            <a
                                :href="`http://127.0.0.1:8000/storage/${order.updated_cv}`"
                                v-if="order.updated_cv"
                                target="_blank"
                                download
                            >
                                Download CV
                            </a>
                            <span class="badge text-dark" v-else>You will find Your Upgraded CV here</span>
                        </td>
                        <td>
                            <button
                                class="btn btn-info btn-sm"
                                @click="seeDetails(order)"
                            >
                                Details
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
    computed: {
        sortedOrders() {
            // Sort orders by date in ascending order
            return this.orders
                .slice()
                .sort(
                    (b, a) => new Date(a.created_at) - new Date(b.created_at)
                );
        },
    },
    methods: {
        async fetchUsers() {
            const user = JSON.parse(localStorage.getItem("user"));
            if (!user || !user.email) {
                console.error("User email not found in localStorage");
                return;
            }

            try {
                const res = await axios.get(
                    `/api/payments/allByMail/${user.email}`
                );
                this.orders = res.data; // Assign fetched data to orders
                console.log(res.data);
            } catch (error) {
                console.error("Error fetching orders:", error);
            }
        },
        seeDetails(order) {
            // Handle see details logic here
            console.log("See details for order:", order);
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            return new Intl.DateTimeFormat("en-GB", {
                day: "numeric",
                month: "long",
                year: "numeric",
            }).format(date); // Format as "1 March 2025"
        },
    },
    created() {
        this.fetchUsers();
    },
};
</script>

<style scoped>
/* No custom CSS needed since we're using Bootstrap classes */
</style>