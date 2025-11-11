<template>
    <main class="main">
        <!-- Page Title & Breadcrumb -->
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li>
                        <h1>Invite Visitor</h1>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">
                            <svg width="16" height="16" viewBox="0 0 17 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z"
                                    stroke="var(--bs-body-color)" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="var(--bs-body-color)"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Invite Visitor</li>
                </ol>
            </nav>
        </div>

        <!-- Page Content -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- Left Sidebar -->
                <div class="col-xl-3 col-md-4 mb-4">
                    <div class="card h-auto shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <!-- Avatar -->
                            <div class="avatar avatar-xl position-relative mx-auto">
                                <img v-if="previewImage" :src="previewImage"
                                    class="w-100 h-100 rounded-circle object-fit-cover" alt="Avatar" />
                                <div v-else
                                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 100px; height: 100px; font-size: 2rem;">
                                    {{ initials }}
                                </div>

                                <!-- Hidden file input -->
                                <input type="file" class="d-none" ref="fileInput" accept=".png,.jpg,.jpeg"
                                    @change="handleFileUpload" />

                                <!-- Camera button -->
                                <a href="javascript:void(0);"
                                    class="btn btn-square btn-primary btn-sm position-absolute bottom-0 end-0 shadow-sm rounded-circle border border-white"
                                    @click="openPhotoOptions" data-bs-toggle="tooltip" title="Upload or Capture Photo">
                                    <i class="fa fa-camera"></i>
                                </a>
                            </div>

                            <!-- Basic Info -->
                            <div class="mt-3">
                                <h6 class="mb-0">{{ form.name || "New Visitor" }}</h6>
                                <span class="text-muted">{{ form.company || "No Company" }}</span>
                            </div>

                            <!-- Venues -->
                            <div class="mt-4 text-start small px-3">
                                <p class="fw-bold mb-1">📍 Venues:</p>
                                <ul class="list-unstyled ps-2 mb-0">
                                    <li v-if="form.venues.length" v-for="(venue, i) in form.venues" :key="i">
                                        • {{ venue }}
                                    </li>
                                    <li v-else class="text-muted">No venues added</li>
                                </ul>
                            </div>
                        </div>

                        <!-- History & Badge -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item py-3">
                                <strong>📜 History:</strong>
                                <div v-if="form.history?.length" class="mt-2">
                                    <ul class="list-unstyled mb-0">
                                        <li v-for="(item, i) in form.history" :key="i">
                                            • {{ item }}
                                        </li>
                                    </ul>
                                </div>
                                <p v-else class="text-muted mt-2 mb-0">No history available</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between py-3">
                                <span>🎟️ Badge No</span>
                                <span>{{ form.badge_no || "---" }}</span>
                            </li>
                        </ul>

                        <div class="card-footer p-4">
                            <a href="javascript:void(0);" class="btn btn-primary w-100">View Visitors</a>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="col-xl-9 col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header">
                            <h6 class="card-title mb-0 fw-semibold">Visitor Invitation Form</h6>
                        </div>
                        <div class="card-body">
                            <!-- Search -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Search Visitor (Email / Phone / Company)</label>
                                <div class="input-group">
                                    <input v-model="searchQuery" class="form-control"
                                        placeholder="Enter email, phone, or company..." @keyup.enter="searchVisitor" />
                                    <button class="btn btn-primary" @click="searchVisitor">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                                <small v-if="searchError" class="text-danger">{{ searchError }}</small>

                                <div v-if="searchResults.length" class="mt-3 border rounded p-2 bg-light">
                                    <p class="fw-bold mb-2">Select a visitor to re-invite:</p>
                                    <ul class="list-group">
                                        <li v-for="v in searchResults" :key="v.id"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                            @click="selectVisitor(v)" style="cursor: pointer">
                                            <div>
                                                <strong>{{ v.name }}</strong><br />
                                                <small class="text-muted">{{ v.email }} | {{ v.phone }}</small>
                                            </div>
                                            <span class="badge bg-primary">{{ v.company || "N/A" }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Form -->
                            <form @submit.prevent="inviteVisitor">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">Name *</label>
                                        <input v-model="form.name" class="form-control" required />
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Email *</label>
                                        <input v-model="form.email" type="email" class="form-control" required />
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Phone</label>
                                        <input v-model="form.phone" class="form-control" />
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Company</label>
                                        <input v-model="form.company" class="form-control" />
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Gender</label>
                                        <select v-model="form.gender" class="form-select">
                                            <option disabled value="">Select gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Venues</label>
                                        <input v-model="venueInput" class="form-control"
                                            placeholder="Type a venue and press Enter"
                                            @keyup.enter.prevent="addVenue" />
                                        <div class="mt-2">
                                            <span v-for="(venue, i) in form.venues" :key="i"
                                                class="badge bg-primary me-1 mb-1">
                                                {{ venue }}
                                                <button type="button" class="btn-close btn-close-white btn-sm ms-1"
                                                    @click="removeVenue(i)"></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Purpose of Visit</label>
                                        <textarea v-model="form.purpose" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
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

        <!-- 📷 Modal: Upload or Capture -->
        <div class="modal fade" id="photoOptionModal" tabindex="-1" ref="photoOptionModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white">
                            <i class="fa fa-camera me-2 text-white"></i>
                            Choose Photo Option
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center py-4">
                        <button class="btn btn-outline-primary w-100 mb-3" @click="triggerUpload">
                            <i class="fa fa-upload me-2"></i> Upload from Device
                        </button>
                        <button class="btn btn-outline-success w-100" @click="openCamera">
                            <i class="fa fa-video me-2"></i> Capture from Camera
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 📸 Camera Modal -->
        <div class="modal fade" id="cameraModal" tabindex="-1" ref="cameraModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="fa fa-video me-2"></i>Capture Photo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <video ref="video" autoplay playsinline class="border rounded w-100"></video>
                        <canvas ref="canvas" class="d-none"></canvas>
                        <div v-if="faceStatus" class="mt-3">
                            <small
                                :class="{ 'text-success': faceStatus === 'Face Detected ✅', 'text-danger': faceStatus !== 'Face Detected ✅' }">{{
                                faceStatus }}</small>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success" @click="capturePhoto" :disabled="!faceDetected">
                            <i class="fa fa-camera me-1"></i> Capture
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import AppRoutes from "@/routes";
import AdminLayout from "@/Layouts/AdminLayout.vue";

defineOptions({ layout: AdminLayout });

const form = useForm({
    id: null,
    name: "",
    email: "",
    phone: "",
    company: "",
    purpose: "",
    badge_no: "",
    gender: "",
    venues: [],
    history: [],
    photo: null,
});

const searchQuery = ref("");
const searchResults = ref([]);
const searchError = ref("");
const previewImage = ref(null);
const venueInput = ref("");
const fileInput = ref(null);
const photoOptionModal = ref(null);
const cameraModal = ref(null);
const video = ref(null);
const canvas = ref(null);

let cameraInstance = null;
let faceDetector = null;
let detectionInterval = null;

const faceDetected = ref(false);
const faceStatus = ref("");

const initials = computed(() => {
    if (!form.name) return "V";
    const parts = form.name.split(" ");
    return parts.length > 1
        ? parts[0][0].toUpperCase() + parts[1][0].toUpperCase()
        : parts[0][0].toUpperCase();
});

const openPhotoOptions = () => new bootstrap.Modal(photoOptionModal.value).show();

const triggerUpload = () => {
    bootstrap.Modal.getInstance(photoOptionModal.value).hide();
    fileInput.value.click();
};

const handleFileUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.photo = file;
        const reader = new FileReader();
        reader.onload = (event) => (previewImage.value = event.target.result);
        reader.readAsDataURL(file);
    }
};

// 🧠 Face Detection + Camera autofocus
const openCamera = async () => {
    bootstrap.Modal.getInstance(photoOptionModal.value).hide();
    const modal = new bootstrap.Modal(cameraModal.value);
    modal.show();

    faceDetected.value = false;
    faceStatus.value = "Initializing camera...";

    try {
        cameraInstance = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: "user", focusMode: "continuous" },
        });
        video.value.srcObject = cameraInstance;

        // Try to use FaceDetector API
        if ("FaceDetector" in window) {
            faceDetector = new FaceDetector({ fastMode: true, maxDetectedFaces: 1 });
            faceStatus.value = "Looking for face...";

            detectionInterval = setInterval(async () => {
                try {
                    const faces = await faceDetector.detect(video.value);
                    if (faces.length > 0) {
                        faceDetected.value = true;
                        faceStatus.value = "Face Detected ✅";
                    } else {
                        faceDetected.value = false;
                        faceStatus.value = "No clear face detected ❌";
                    }
                } catch {
                    faceStatus.value = "Face detection not supported.";
                    clearInterval(detectionInterval);
                }
            }, 600);
        } else {
            faceStatus.value = "Face detection not supported in this browser.";
        }
    } catch (err) {
        alert("Unable to access camera. Please allow permission.");
        faceStatus.value = "Camera access denied.";
    }
};

const capturePhoto = () => {
    const context = canvas.value.getContext("2d");
    canvas.value.width = video.value.videoWidth;
    canvas.value.height = video.value.videoHeight;
    context.drawImage(video.value, 0, 0);
    const dataUrl = canvas.value.toDataURL("image/png");
    previewImage.value = dataUrl;

    const arr = dataUrl.split(",");
    const mime = arr[0].match(/:(.*?);/)[1];
    const bstr = atob(arr[1]);
    let n = bstr.length;
    const u8arr = new Uint8Array(n);
    while (n--) u8arr[n] = bstr.charCodeAt(n);
    form.photo = new File([u8arr], "visitor_photo.png", { type: mime });

    // stop detection
    if (detectionInterval) clearInterval(detectionInterval);
    if (cameraInstance) cameraInstance.getTracks().forEach((t) => t.stop());

    bootstrap.Modal.getInstance(cameraModal.value).hide();
};

const addVenue = () => {
    if (venueInput.value.trim() && !form.venues.includes(venueInput.value.trim())) {
        form.venues.push(venueInput.value.trim());
        venueInput.value = "";
    }
};
const removeVenue = (i) => form.venues.splice(i, 1);

const selectVisitor = (v) => {
    Object.assign(form, v);
    previewImage.value = v.photo_url || null;
    searchResults.value = [];
};

const searchVisitor = async () => {
    searchError.value = "";
    searchResults.value = [];
    if (!searchQuery.value)
        return (searchError.value = "Please enter email, phone, or company.");
    try {
        const res = await axios.post(AppRoutes.visitor.search, { query: searchQuery.value });
        if (res.data.found && Array.isArray(res.data.visitors)) {
            searchResults.value = res.data.visitors;
        } else if (res.data.visitor) {
            selectVisitor(res.data.visitor);
        } else {
            searchError.value = "No existing record found.";
        }
    } catch {
        searchError.value = "Error occurred.";
    }
};

const inviteVisitor = async () => {
    const data = new FormData();
    Object.keys(form).forEach((k) => {
        if (k === "venues") data.append(k, JSON.stringify(form.venues));
        else data.append(k, form[k] ?? "");
    });

    const route = form.id ? AppRoutes.visitor.reinvite(form.id) : AppRoutes.visitor.invite;

    try {
        const res = await axios.post(route, data);
        alert(res.data.message || "Visitor invited successfully!");
        form.reset();
        previewImage.value = null;
    } catch {
        alert("Something went wrong while inviting visitor.");
    }
};
</script>

<style scoped>
.card-title {
    font-weight: 600;
}
</style>
