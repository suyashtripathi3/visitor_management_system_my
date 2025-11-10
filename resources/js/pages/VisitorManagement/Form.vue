<template>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <!-- 🧍 Left Profile Section -->
            <div class="col-md-4">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <!-- 🖼️ Profile Picture / Auto Initials -->
                        <div class="mb-3">
                            <div v-if="previewImage" class="position-relative d-inline-block">
                                <img :src="previewImage" class="rounded-circle border border-3 border-primary"
                                    width="100" height="100" />
                                <button class="btn btn-sm btn-danger rounded-circle position-absolute top-0 end-0"
                                    @click="removePhoto" type="button" style="transform: translate(25%, -25%)">
                                    <i class="fa fa-times small"></i>
                                </button>
                            </div>

                            <div v-else
                                class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center mx-auto"
                                style="width:100px; height:100px; font-size:2rem;">
                                {{ initials }}
                            </div>
                        </div>

                        <!-- 📸 Upload -->
                        <div class="mb-3">
                            <label for="photo" class="form-label fw-bold">Upload Photo</label>
                            <input type="file" id="photo" class="form-control" accept="image/*"
                                @change="handleFileUpload" />
                        </div>

                        <!-- 🧾 Basic Info -->
                        <h5 class="fw-bold mb-1">{{ form.name || "New Visitor" }}</h5>
                        <p class="text-muted">{{ form.company || "No Company" }}</p>

                        <div class="border-top pt-3 mt-3 text-start small">
                            <p><strong>Phone:</strong> {{ form.phone || "---" }}</p>
                            <p><strong>Email:</strong> {{ form.email || "---" }}</p>
                            <p><strong>Badge:</strong> {{ form.badge_no || "---" }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📝 Right Form -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 text-primary fw-bold">
                            <i class="fa fa-envelope me-2"></i> Invite Visitor
                        </h5>
                    </div>

                    <div class="card-body">
                        <!-- 🔍 Smart Search -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Search Visitor (Email / Phone / Company)</label>
                            <div class="input-group">
                                <input v-model="searchQuery" class="form-control"
                                    placeholder="Enter email, phone, or company..." @keyup.enter="searchVisitor" />
                                <button class="btn btn-primary" @click="searchVisitor">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                            <small v-if="searchError" class="text-danger">{{ searchError }}</small>

                            <!-- 📋 Multiple Results -->
                            <div v-if="searchResults.length" class="mt-3 border rounded p-2 bg-light">
                                <p class="fw-bold mb-2">Select a visitor to re-invite:</p>
                                <ul class="list-group">
                                    <li v-for="v in searchResults" :key="v.id"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                        @click="selectVisitor(v)" style="cursor:pointer">
                                        <div>
                                            <strong>{{ v.name }}</strong><br />
                                            <small class="text-muted">{{ v.email }} | {{ v.phone }}</small>
                                        </div>
                                        <span class="badge bg-primary">{{ v.company || "N/A" }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- 🧾 Visitor Form -->
                        <form @submit.prevent="inviteVisitor">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Name *</label>
                                    <input v-model="form.name" class="form-control" required />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email *</label>
                                    <input v-model="form.email" class="form-control" required />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Phone</label>
                                    <input v-model="form.phone" class="form-control" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Company</label>
                                    <input v-model="form.company" class="form-control" />
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Purpose of Visit</label>
                                    <textarea v-model="form.purpose" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-4 d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-paper-plane me-1"></i>
                                    {{ form.id ? "Re-Invite Visitor" : "Invite Visitor" }}
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
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppRoutes from "@/routes";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";

defineOptions({ layout: AdminLayout });

const searchQuery = ref("");
const searchResults = ref([]);
const searchError = ref("");
const previewImage = ref(null);

const form = useForm({
    id: null,
    name: "",
    email: "",
    phone: "",
    company: "",
    purpose: "",
    badge_no: "",
    photo: null,
});

// 🧠 Auto initials
const initials = computed(() => {
    if (!form.name) return "V";
    const parts = form.name.split(" ");
    return parts.length > 1
        ? parts[0][0].toUpperCase() + parts[1][0].toUpperCase()
        : parts[0][0].toUpperCase();
});

// 📷 File upload
const handleFileUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.photo = file;
        const reader = new FileReader();
        reader.onload = (event) => (previewImage.value = event.target.result);
        reader.readAsDataURL(file);
    }
};

const removePhoto = () => {
    form.photo = null;
    previewImage.value = null;
};

// 🔍 Search visitor
const searchVisitor = async () => {
    searchError.value = "";
    searchResults.value = [];

    if (!searchQuery.value) {
        searchError.value = "Please enter email, phone, or company.";
        return;
    }

    try {
        const response = await axios.post(AppRoutes.visitor.search, {
            query: searchQuery.value,
        });

        if (response.data.found && Array.isArray(response.data.visitors)) {
            searchResults.value = response.data.visitors;
        } else if (response.data.found && response.data.visitor) {
            selectVisitor(response.data.visitor);
        } else {
            searchError.value = "No existing record found. You can invite this visitor.";
        }
    } catch (err) {
        console.error(err);
        searchError.value = "Something went wrong. Try again.";
    }
};

// 📋 Select visitor from list
const selectVisitor = (visitor) => {
    Object.assign(form, visitor);
    previewImage.value = visitor.photo_url || null;
    searchResults.value = [];
};

// 📤 Invite / Re-invite visitor
const inviteVisitor = () => {
    const data = new FormData();
    Object.keys(form).forEach((key) => data.append(key, form[key] ?? ""));

    const route = form.id ? AppRoutes.visitor.reinvite(form.id) : AppRoutes.visitor.invite;

    axios
        .post(route, data)
        .then((res) => {
            alert(res.data.message || "Invitation sent successfully!");
            form.reset();
            previewImage.value = null;
        })
        .catch((err) => {
            console.error(err);
            alert("Something went wrong while inviting visitor.");
        });
};
</script>
