<template>
  <!-- Page Title & Breadcrumb -->
  <div class="page-title">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li><h1>{{ isEdit ? "Edit User" : "Create User" }}</h1></li>
        <li class="breadcrumb-item">
          <a :href="route('dashboard')">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a :href="route('admin.users.index')">Users</a>
        </li>
        <li class="breadcrumb-item active">
          {{ isEdit ? "Edit" : "Create" }}
        </li>
      </ol>
    </nav>
  </div>

  <div class="container-fluid mt-3">

    <div class="card shadow-sm">
      <div class="card-header">
        <h4 class="card-title mb-0">{{ isEdit ? "Update User" : "Add New User" }}</h4>
      </div>

      <div class="card-body">

        <!-- Form -->
        <form @submit.prevent="submit">

          <!-- Name -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Name</label>
            <input v-model="form.name" type="text" class="form-control" placeholder="Enter name" required>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input v-model="form.email" type="email" class="form-control" placeholder="Enter email" required>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>

            <input 
              v-model="form.password" 
              type="password" 
              class="form-control" 
              :placeholder="isEdit ? 'Leave blank to keep old password' : 'Enter password'"
              :required="!isEdit"
            >
          </div>

          <!-- Buttons -->
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a :href="route('admin.users.index')" class="btn btn-secondary">
              Cancel
            </a>

            <button type="submit" class="btn btn-primary">
              {{ isEdit ? "Update User" : "Create User" }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import AppRoutes from "@/routes.js";

defineOptions({ layout: AdminLayout })

const props = defineProps({
  user: Object | null
})

const isEdit = props.user !== null

const form = useForm({
  name: props.user?.name ?? '',
  email: props.user?.email ?? '',
  password: ''
})

const submit = () => {

    if (isEdit) {
        form.put(AppRoutes.users.update(props.user.id));
    } else {
        form.post(AppRoutes.users.store);
    }
}
</script>
