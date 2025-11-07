<template>
  <div class="page-title">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li><h1>{{ isEdit ? 'Edit Role' : 'Add Role' }}</h1></li>
        <li class="breadcrumb-item">
          <a :href="route('dashboard')">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a :href="AppRoutes.roles.index">Roles</a>
        </li>
        <li class="breadcrumb-item active">{{ isEdit ? 'Edit' : 'Create' }}</li>
      </ol>
    </nav>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-6 mx-auto">
        <div class="card">
          <div class="card-header border-0">
            <h4 class="card-title">{{ isEdit ? 'Edit Role' : 'Create New Role' }}</h4>
          </div>

          <div class="card-body">
            <!-- show server flash success (if any) -->
            <div v-if="flash.success" class="alert alert-success">
              {{ flash.success }}
            </div>

            <form @submit.prevent="submitForm" novalidate>
              <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.name }"
                  placeholder="Enter role name"
                  v-model="form.name"
                  :disabled="form.processing"
                />
                <div v-if="form.errors.name" class="invalid-feedback">
                  {{ form.errors.name }}
                </div>
              </div>

              <div class="text-end">
                <button type="button" class="btn btn-secondary me-2" @click="goBack" :disabled="form.processing">
                  Cancel
                </button>
                <button type="submit" class="btn btn-primary" :disabled="form.processing">
                  <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                  {{ form.processing ? (isEdit ? 'Updating...' : 'Creating...') : (isEdit ? 'Update Role' : 'Create Role') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { router, useForm, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import AppRoutes from "@/routes.js";
import { computed, watch } from 'vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  role: {
    type: Object,
    default: null
  }
})

// get flash messages (if backend returns with('success', '...'))
const page = usePage()
const flash = computed(() => page.props.value?.flash || {})

// initialize form with role data (if editing) or empty for create
const form = useForm({
  name: props.role?.name || ''
})

const isEdit = computed(() => !!props.role)

// If server sends errors or we want to react when role changes from parent, watch:
watch(() => props.role, (newVal) => {
  form.reset()
  form.name = newVal?.name || ''
})

// submit handler — uses AppRoutes (string paths)
const submitForm = () => {
  // basic client-side guard: don't submit empty name
  if (!form.name || form.name.trim().length === 0) {
    form.setError('name', 'Role name is required.')
    return
  }

  if (isEdit.value) {
    // put to /admin-settings/roles/{id}
    form.put(AppRoutes.roles.update(props.role.id), {
      preserveState: false,
      onSuccess: () => {
        // server usually redirects to index — but ensure we land back on list
        router.get(AppRoutes.roles.index)
      }
    })
  } else {
    // post to /admin-settings/roles
    form.post(AppRoutes.roles.store, {
      preserveState: false,
      onSuccess: () => {
        router.get(AppRoutes.roles.index)
      }
    })
  }
}

// go back to roles list
const goBack = () => {
  router.get(AppRoutes.roles.index)
}
</script>
