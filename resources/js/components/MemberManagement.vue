<template>
    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Pengelolaan Data Anggota</h5>
            <button class="btn btn-primary btn-sm" @click="openModal()">
                <i class="bi bi-plus-lg"></i> Tambah Anggota
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Tahun Masuk</th>
                            <th>Lulus Madrasah</th>
                            <th>Kampus</th>
                            <th>Wali</th>
                            <th>Job</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="member in members" :key="member.id">
                            <td>{{ member.id }}</td>
                            <td class="fw-bold">{{ member.nama }}</td>
                            <td>{{ member.tahun_masuk }}</td>
                            <td>{{ member.lulus_madrasah || '-' }}</td>
                            <td>{{ member.kampus || '-' }}</td>
                            <td>{{ member.wali || '-' }}</td>
                            <td>{{ member.job || '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" @click="openModal(member)" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                          <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </button>
                                    <button class="btn btn-outline-danger" @click="deleteMember(member.id)" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="members.length === 0">
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data anggota.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="memberModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg shadow-lg">
                <div class="modal-content border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">{{ editing ? 'Edit Anggota' : 'Tambah Anggota' }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="saveMember">
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Nama Lengkap</label>
                                    <input type="text" class="form-control shadow-none" v-model="form.nama" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Tahun Masuk</label>
                                    <input type="number" class="form-control shadow-none" v-model="form.tahun_masuk" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small">Lulus Madrasah</label>
                                    <input type="number" class="form-control shadow-none" v-model="form.lulus_madrasah">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Kampus</label>
                                    <input type="text" class="form-control shadow-none" v-model="form.kampus">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Wali</label>
                                    <input type="text" class="form-control shadow-none" v-model="form.wali">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Job / Pekerjaan</label>
                                    <input type="text" class="form-control shadow-none" v-model="form.job">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Alamat Lengkap</label>
                                    <textarea class="form-control shadow-none" v-model="form.alamat_lengkap" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-4" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm me-1"></span>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
    data() {
        return {
            members: [],
            form: {
                id: null,
                nama: '',
                tahun_masuk: new Date().getFullYear(),
                lulus_madrasah: '',
                kampus: '',
                wali: '',
                job: '',
                alamat_lengkap: ''
            },
            editing: false,
            loading: false,
            modal: null
        }
    },
    mounted() {
        this.fetchMembers();
        this.modal = new Modal(document.getElementById('memberModal'));
    },
    methods: {
        async fetchMembers() {
            try {
                const response = await axios.get('/api/members');
                this.members = response.data;
            } catch (err) {
                console.error('Error fetching members:', err);
            }
        },
        openModal(member = null) {
            if (member) {
                this.editing = true;
                this.form = { ...member };
            } else {
                this.editing = false;
                this.form = {
                    id: null,
                    nama: '',
                    tahun_masuk: new Date().getFullYear(),
                    lulus_madrasah: '',
                    kampus: '',
                    wali: '',
                    job: '',
                    alamat_lengkap: ''
                };
            }
            this.modal.show();
        },
        async saveMember() {
            this.loading = true;
            try {
                if (this.editing) {
                    await axios.put(`/api/members/${this.form.id}`, this.form);
                } else {
                    await axios.post('/api/members', this.form);
                }
                this.fetchMembers();
                this.modal.hide();
            } catch (err) {
                alert(err.response?.data?.message || 'Gagal menyimpan data.');
            } finally {
                this.loading = false;
            }
        },
        async deleteMember(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                try {
                    await axios.delete(`/api/members/${id}`);
                    this.fetchMembers();
                } catch (err) {
                    alert('Gagal menghapus data.');
                }
            }
        }
    }
}
</script>

<style scoped>
.card {
    border-radius: 12px;
    overflow: hidden;
}
.table thead th {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
}
.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}
.btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2653d4;
}
</style>
