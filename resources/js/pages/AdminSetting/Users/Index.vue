<template>

    <!-- ✅ Page Title -->
    <div class="page-title">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><h1>Users</h1></li>
                <li class="breadcrumb-item">
                    <a :href="route('dashboard')">Home</a>
                </li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid">

        <div class="row">

            <!-- ✅ User Count Cards -->
            <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body overflow-hidden">
                                <div class="row gx-5 gy-3">

                                    <!-- Start - Not Started -->
                                    <div class="col-xl-2 col-sm-4 col-6 border-end">
                                        <div class="d-flex align-items-center">
                                            <h2 class="text-primary my-0 fs-3 me-2">{{ totalUsers }}</h2>
                                            <span class="text-dark fw-medium fs-5">Total Users</span>
                                        </div>
                                        <span>Tasks assigne</span>
                                    </div>
                                    <!-- End - Not Started -->

                                    <!-- Start - In Progress -->
                                    <div class="col-xl-2 col-sm-4 col-6 border-end">
                                        <div class="d-flex align-items-center ">
                                            <h2 class="text-purple my-0 fs-3 me-2">7</h2>
                                            <span class="text-dark fw-medium fs-5">In Progress</span>
                                        </div>
                                        <span>Tasks assigne</span>
                                    </div>
                                    <!-- End - In Progress -->

                                    <!-- Start - Testing -->
                                    <div class="col-xl-2 col-sm-4 col-6 border-end">
                                        <div class="d-flex align-items-center">
                                            <h2 class="text-warning my-0 fs-3 me-2">13</h2>
                                            <span class="text-dark fw-medium fs-5">Testing</span>
                                        </div>
                                        <span>Tasks assigne</span>
                                    </div>
                                    <!-- End - Testing -->

                                    <!-- Start - Awaiting -->
                                    <div class="col-xl-2 col-sm-4 col-6 border-end">
                                        <div class="d-flex align-items-center">
                                            <h2 class="text-danger my-0 fs-3 me-2">11</h2>
                                            <span class="text-dark fw-medium fs-5">Awaiting</span>
                                        </div>
                                        <span>Tasks assigne</span>
                                    </div>
                                    <!-- End - Awaiting -->

                                    <!-- Start - Complete -->
                                    <div class="col-xl-2 col-sm-4 col-6 border-end">
                                        <div class="d-flex align-items-center">
                                            <h2 class="text-success my-0 fs-3 me-2">21</h2>
                                            <span class="text-dark fw-medium fs-5">Complete</span>
                                        </div>
                                        <span>Tasks assigne</span>
                                    </div>
                                    <!-- End - Complete -->

                                    <!-- Start - Pending -->
                                    <div class="col-xl-2 col-sm-4 col-6">
                                        <div class="d-flex align-items-center">
                                            <h2 class="text-danger my-0 fs-3 me-2">16</h2>
                                            <span class="text-dark fw-medium fs-5">Pending</span>
                                        </div>
                                        <span>Tasks assigne</span>
                                    </div>
                                    <!-- End - Pending -->

                                </div>
                            </div>
                        </div>
                    </div>

            <!-- ✅ User Table -->
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Users List</h4>

                        <!-- Add New User -->
                        <button class="btn btn-primary btn-sm" @click="createUser">
                            + Add User
                        </button>
                    </div>

                    <div class="card-body table-card-body px-0 pt-0 pb-1">
                        <div class="table-responsive check-wrapper">
                            <table class="table table-sm table-bottom-borderless">
                                <thead class="table-primary text-nowrap">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="text-nowrap">

                                    <!-- ✅ Loop Users -->
                                    <tr v-for="(user, index) in users" :key="user.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <h6 class="mb-0">{{ user.name }}</h6>
                                        </td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ new Date(user.created_at).toLocaleDateString() }}</td>

                                        <td class="text-end">

                                            <!-- Edit -->
                                            <button
                                                class="btn btn-sm btn-primary me-1"
                                                @click="editUser(user.id)"
                                            >
                                                Edit
                                            </button>

                                            <!-- Delete -->
                                            <button
                                                class="btn btn-sm btn-danger"
                                                @click="deleteUser(user.id)"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <tr v-if="users.length === 0">
                                        <td colspan="5" class="text-center py-3">
                                            No users found.
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</template>


<script setup>
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import AppRoutes from "@/routes.js";


defineOptions({ layout: AdminLayout })

// ✅ Accept data from controller
const props = defineProps({
    users: Array,
    totalUsers: Number
})

// ✅ Create user (route for create page)
const createUser = () => {
    router.get(AppRoutes.users.create);
};

// ✅ Edit user
const editUser = (id) => {
    router.get(AppRoutes.users.edit(id));
};


// ✅ Delete user
const deleteUser = (id) => {
    if (confirm("Are you sure you want to delete this Record?")) {
         router.delete(AppRoutes.users.delete(id));
    }
}
</script>
