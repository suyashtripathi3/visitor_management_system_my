<template>
    <div>
        <!-- 🧭 Page Title -->
        <div class="page-title mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li>
                        <h1>Visitors</h1>
                    </li>
                    <li class="breadcrumb-item"><a :href="AppRoutes.dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Visitors</li>
                </ol>
            </nav>
        </div>

        <!-- 📋 Visitor List -->
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex gap-2 align-items-center bg-white">
                <input v-model="search" @input="applyFilter" class="form-control form-control-sm"
                    placeholder="Search visitor..." style="width:200px" />
                <select v-model="status" @change="applyFilter" class="form-select form-select-sm" style="width:150px">
                    <option value="">All</option>
                    <option value="not_checked_in">Not Checked In</option>
                    <option value="checked_in">Checked In</option>
                    <option value="checked_out">Checked Out</option>
                </select>
                <button class="btn btn-primary btn-sm ms-auto" @click="goCreate">
                    <i class="fa fa-plus me-1"></i> Add Visitor
                </button>
            </div>

            <!-- 🧾 Table -->
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Phone</th>
                            <th>Badge</th>
                            <th>Status</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(v, i) in visitors.data" :key="v.id">
                            <td>{{ visitors.from + i }}</td>
                            <td>{{ v.name }}</td>
                            <td>{{ v.company || '-' }}</td>
                            <td>{{ v.phone || '-' }}</td>
                            <td><span class="fw-semibold">{{ v.badge_no || '-' }}</span></td>
                            <td>
                                <span class="badge" :class="{
                                    'bg-secondary': !v.checked_in_at,
                                    'bg-success': v.checked_in_at && !v.checked_out_at,
                                    'bg-danger': v.checked_out_at
                                }">
                                    {{ statusLabel(v) }}
                                </span>
                            </td>
                            <td>{{ v.checked_in_at ?? '-' }}</td>
                            <td>{{ v.checked_out_at ?? '-' }}</td>

                            <td class="text-end">
                                <!-- 👁️ View Details -->
                                <button class="btn btn-sm btn-outline-info me-1" @click="showDetails(v)">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <!-- ✅ Check In / Out -->
                                <button v-if="!v.checked_in_at" class="btn btn-sm btn-outline-success me-1"
                                    @click="checkIn(v.id)">
                                    Check In
                                </button>

                                <button v-else-if="v.checked_in_at && !v.checked_out_at"
                                    class="btn btn-sm btn-outline-warning me-1" @click="checkOut(v.id)">
                                    Check Out
                                </button>

                                <!-- ✏️ Edit / 🗑️ Delete -->
                                <button class="btn btn-sm btn-outline-primary me-1" @click="goEdit(v.id)">
                                    <i class="fa fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" @click="destroy(v.id)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="!visitors.data.length">
                            <td colspan="9" class="text-center p-3 text-muted">No visitors found</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 📄 Pagination -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Showing {{ visitors.from }}–{{ visitors.to }} of {{ visitors.total }}</div>
                <ul class="pagination mb-0">
                    <li v-for="link in visitors.links" :key="link.label"
                        :class="['page-item', { active: link.active }]">
                        <button class="page-link" @click="go(link.url)" v-html="link.label"></button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 🪪 Visitor ID Card Modal -->
        <div class="modal fade" id="visitorModal" tabindex="-1" aria-labelledby="visitorModalLabel" aria-hidden="true"
            ref="visitorModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fa fa-id-badge me-2"></i>Visitor ID Card
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body bg-light">
                        <div class="card border-0 shadow-sm mx-auto" style="max-width: 400px;">
                            <div class="card-body text-center bg-white">
                                <!-- 🖼️ Visitor Photo -->
                                <div class="mb-3">
                                    <img :src="selectedVisitor.photo || 'https://via.placeholder.com/100'"
                                        alt="Visitor Photo" class="rounded-circle border border-3 border-primary"
                                        width="100" height="100" />
                                </div>

                                <!-- 🧾 Visitor Info -->
                                <h5 class="fw-bold text-primary mb-0">{{ selectedVisitor.name }}</h5>
                                <p class="text-muted mb-3">{{ selectedVisitor.company || 'No Company' }}</p>

                                <div class="text-start px-3 small">
                                    <p><strong>Email:</strong> {{ selectedVisitor.email || '—' }}</p>
                                    <p><strong>Phone:</strong> {{ selectedVisitor.phone || '—' }}</p>
                                    <p><strong>Badge No:</strong> <span class="fw-bold">{{ selectedVisitor.badge_no ||
                                            '—' }}</span></p>
                                    <p><strong>Purpose:</strong> {{ selectedVisitor.purpose || '—' }}</p>
                                    <p><strong>Status:</strong>
                                        <span class="badge" :class="{
                                            'bg-secondary': !selectedVisitor.checked_in_at,
                                            'bg-success': selectedVisitor.checked_in_at && !selectedVisitor.checked_out_at,
                                            'bg-danger': selectedVisitor.checked_out_at
                                        }">
                                            {{ statusLabel(selectedVisitor) }}
                                        </span>
                                    </p>
                                    <p><strong>Checked In:</strong> {{ selectedVisitor.checked_in_at || '—' }}</p>
                                    <p><strong>Checked Out:</strong> {{ selectedVisitor.checked_out_at || '—' }}</p>
                                </div>

                                <hr />

                                <div class="text-center">
                                    <button class="btn btn-outline-primary btn-sm" @click="printCard">
                                        <i class="fa fa-print me-1"></i> Print Badge
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-white">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import AppRoutes from "@/routes";
import AdminLayout from "@/Layouts/AdminLayout.vue";

defineOptions({ layout: AdminLayout });

const props = defineProps({
    visitors: Object,
    filters: Object,
});

const visitors = props.visitors;
const search = ref(props.filters?.search ?? "");
const status = ref(props.filters?.status ?? "");
const selectedVisitor = ref({});
const visitorModal = ref(null);
let modalInstance = null;

onMounted(() => {
    modalInstance = new bootstrap.Modal(visitorModal.value);
});

// Filters
const applyFilter = () => {
    router.get(
        AppRoutes.visitor.index,
        { search: search.value, status: status.value },
        { preserveState: true }
    );
};

const go = (url) => url && router.get(url);
const goCreate = () => router.get(AppRoutes.visitor.form);
const goEdit = (id) => router.get(AppRoutes.visitor.form, { id });

// CRUD
const destroy = (id) => {
    if (confirm("Delete this visitor?")) {
        router.delete(AppRoutes.visitor.delete(id), {
            onSuccess: () => router.get(AppRoutes.visitor.index, {}, { replace: true }),
        });
    }
};

const checkIn = (id) => {
    if (confirm("Mark visitor as checked in?")) {
        router.post(AppRoutes.visitor.checkIn(id), {}, { preserveScroll: true });
    }
};

const checkOut = (id) => {
    if (confirm("Mark visitor as checked out?")) {
        router.post(AppRoutes.visitor.checkOut(id), {}, { preserveScroll: true });
    }
};

// 👁️ Show Visitor Card
const showDetails = (visitor) => {
    selectedVisitor.value = visitor;
    modalInstance.show();
};

// 🖨️ Print Badge
const printCard = () => {
    const printContents = document.querySelector(".modal-body .card").outerHTML;
    const printWindow = window.open("", "_blank", "width=600,height=800");
    printWindow.document.write(`
    <html>
      <head>
        <title>Visitor ID Card</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
      </head>
      <body class="d-flex justify-content-center align-items-center p-4 bg-light">
        ${printContents}
      </body>
    </html>
  `);
    printWindow.document.close();
    printWindow.print();
};

// Status Label
const statusLabel = (v) => {
    if (!v.checked_in_at) return "Not Checked In";
    if (v.checked_in_at && !v.checked_out_at) return "Checked In";
    return "Checked Out";
};
</script>
