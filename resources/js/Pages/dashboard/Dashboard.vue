<template>
    <div class="dashboard d-flex">
      <!-- Sidebar Toggle Button for Mobile -->
      <button class="btn btn-primary d-lg-none" type="button" @click="toggleSidebar">
        ☰
      </button>
  
      <!-- Sidebar -->
      <div class="sidebar bg-light p-3" :class="{ 'sidebar-collapsed': !isSidebarOpen }" style="width: 250px;">
        <h2 class="text-center mb-4">Dashboard</h2>
        <ul class="nav flex-column">
          <li class="nav-item">
            <router-link class="nav-link" to="/dashboard/manage-tamplate">Overview</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/dashboard/settings">Settings</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/dashboard/profile">Profile</router-link>
          </li>
        </ul>
      </div>
  
      <!-- Main Content -->
      <div class="content flex-grow-1 p-4">
        <router-view></router-view>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isSidebarOpen: true,
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
  .dashboard {
    min-height: 100vh;
  }
  
  .sidebar {
    transition: transform 0.3s ease-in-out;
  }
  
  .sidebar-collapsed {
    transform: translateX(-250px);
  }
  
  .content {
    margin-left: 250px;
    transition: margin-left 0.3s ease-in-out;
  }
  
  @media (max-width: 992px) {
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      z-index: 1000;
    }
  
    .sidebar-collapsed {
      transform: translateX(-250px);
    }
  
    .content {
      margin-left: 0;
    }
  }
  </style>