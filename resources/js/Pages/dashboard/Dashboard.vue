<template>
  <div class="dashboard">
    <!-- Toggle Button (Always Visible) -->
    <button class="btn btn-primary sidebar-toggle position-fixed" type="button" @click="toggleSidebar">
      ☰
    </button>

    <!-- Sidebar -->
    <div
      class="sidebar bg-light p-3 position-fixed vh-100"
      :class="{ 'sidebar-visible': isSidebarOpen }"
    >
      <h2 class="text-center mb-4">Dashboard</h2>
      <ul class="nav flex-column">
        <li class="nav-item">
          <router-link class="nav-link" to="/dashboard/manage-tamplate">Tamplate</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/dashboard/orders">Orders</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/dashboard/profile">Profile</router-link>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="content p-4" :class="{ 'content-full-width': !isSidebarOpen }">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isSidebarOpen: false, // Sidebar hidden by default
    };
  },
  methods: {
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
    },
  },
};
</script>

<style scoped>
/* Toggle Button */
.sidebar-toggle {
  top: 10px;
  left: 10px;
  z-index: 1001; /* Ensure button is above everything */
}

/* Sidebar */
.sidebar {
  width: 250px;
  left: -250px; /* Hidden by default */
  z-index: 1000; /* Ensure sidebar is above content */
  transition: transform 0.3s ease-in-out;
}

.sidebar-visible {
  transform: translateX(250px); /* Slide in when visible */
}

/* Main Content */
.content {
  margin-left: 0;
  width: 100%;
  transition: margin-left 0.3s ease-in-out;
}

.content-full-width {
  margin-left: 0; /* Full width when sidebar is hidden */
}
</style>