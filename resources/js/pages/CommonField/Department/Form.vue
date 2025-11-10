<template>
<div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.4)">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">{{ isEdit ? "Edit Department" : "Add Department" }}</h5>
        <button type="button" class="btn-close" @click="emit('close')"></button>
      </div>

      <form @submit.prevent="submitForm">
        <div class="modal-body">

          <!-- Department Name -->
          <div class="mb-3">
            <label>Department Name</label>
            <input v-model="form.name" class="form-control" :class="{ 'is-invalid': errors.name }">
            <div class="invalid-feedback" v-if="errors.name">{{ errors.name }}</div>
          </div>

          <!-- Status -->
          <!-- <div class="mb-3">
            <label>Status</label>
            <select v-model="form.status" class="form-select" :class="{ 'is-invalid': errors.status }">
              <option value="">Select Status</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
            <div class="invalid-feedback" v-if="errors.status">{{ errors.status }}</div>
          </div> -->

        </div>

        <div class="modal-footer">
          <button type="button" @click="emit('close')" class="btn btn-secondary">Cancel</button>
          <button type="submit" class="btn btn-primary">{{ isEdit ? "Update" : "Save" }}</button>
        </div>

      </form>

    </div>
  </div>
</div>

<div class="modal-backdrop fade show"></div>
</template>

<script setup>
import { ref } from "vue"
import { useForm } from "@inertiajs/vue3"
import axios from "axios"
import AppRoutes from "@/routes"

const props = defineProps({
  departmentId: Number || null
})

const emit = defineEmits(["close"])
const isEdit = props.departmentId !== null

// Form
const form = useForm({
  name: "",
  status: "1"
})

const errors = ref({})

// Load department for edit
if (isEdit) {
    alert("edit");

}

// Submit
const submitForm = () => {
  errors.value = {}
  if (!form.name) errors.value.name = "Department name is required"
  if (form.status === "") errors.value.status = "Select status"

  if (Object.keys(errors.value).length) return

  if (isEdit) {
    form.put(AppRoutes.departments.update(props.departmentId), { onSuccess: () => emit("close") })
  } else {
    form.post(AppRoutes.common.departments.store, {
    onSuccess: () => emit("close")
})
  }
}
</script>

<style scoped>
.modal-backdrop {
  z-index: 1040;
}
.modal {
  z-index: 1050;
}
</style>
