<script setup>
import { ref, onMounted } from "vue";

const userData = ref(null);

onMounted(() => {
    const storedData = localStorage.getItem("paymentSubmitted");
    userData.value = storedData === "true"; // boolean এ রূপান্তর করা হলো
});
</script>

<template>
    <div>
        This is the confirm order page 
        <span v-if="userData">Payment success</span>
        <span v-else>Please pay fast</span> <!-- `v-else` আলাদাভাবে ব্যবহার করতে হবে -->
    </div>
</template>
