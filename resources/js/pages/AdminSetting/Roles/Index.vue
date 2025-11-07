<template>

    <!-- ✅ Page Title -->
    <div class="page-title">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><h1>Roles</h1></li>
                <li class="breadcrumb-item">
                    <a :href="route('dashboard')">Home</a>
                </li>
                <li class="breadcrumb-item active">Roles</li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid">

        <div class="row">

            <!-- ✅ Role Summary Cards -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body overflow-hidden">
                        <div class="row gx-5 gy-3">

                            <div class="col-xl-3 col-sm-6 col-6 border-end">
                                <div class="d-flex align-items-center">
                                    <h2 class="text-primary my-0 fs-3 me-2">{{ totalRoles }}</h2>
                                    <span class="text-dark fw-medium fs-5">Total Roles</span>
                                </div>
                                <span>Roles available in system</span>
                            </div>

                            <div class="col-xl-3 col-sm-6 col-6">
                                <div class="d-flex align-items-center">
                                    <h2 class="text-success my-0 fs-3 me-2">Active</h2>
                                    <span class="text-dark fw-medium fs-5">Status</span>
                                </div>
                                <span>All roles are active</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- ✅ Roles Table -->
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Roles List</h4>

                        <button class="btn btn-primary btn-sm" @click="createRole">
                            + Add Role
                        </button>
                    </div>

                    <div class="card-body table-card-body px-0 pt-0 pb-1">
                        <div class="table-responsive check-wrapper">
                            <table class="table table-sm table-bottom-borderless">
                                <thead class="table-primary text-nowrap">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Role Name</th>
                                        <th>Created At</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="text-nowrap">

                                    <tr v-for="(role, index) in roles" :key="role.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <h6 class="mb-0">{{ role.name }}</h6>
                                        </td>
                                        <td>{{ new Date(role.created_at).toLocaleDateString() }}</td>

                                        <td class="text-end">
                                            <button
                                                class="btn btn-sm btn-primary me-1"
                                                @click="editRole(role.id)"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                class="btn btn-sm btn-danger"
                                                @click="deleteRole(role.id)"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <tr v-if="roles.length === 0">
                                        <td colspan="4" class="text-center py-3">
                                            No roles found.
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

const props = defineProps({
    roles: Array,
    totalRoles: Number
})

// ✅ Create role
const createRole = () => {
    router.get(AppRoutes.roles.create);
};

// ✅ Edit role
const editRole = (id) => {
    router.get(AppRoutes.roles.edit(id));
};

// ✅ Delete role
const deleteRole = (id) => {
    if (confirm("Are you sure you want to delete this role?")) {
        router.delete(AppRoutes.roles.delete(id));
    }
};
</script>
