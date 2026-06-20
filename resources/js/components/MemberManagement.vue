<template>
    <div class="member-management-container">
        <!-- Header Section -->
        <div class="section-header mb-4">
            <div>
                <h4 class="section-title"><i class="bi bi-people-fill me-2"></i>Pengelolaan Data Anggota</h4>
                <p class="section-subtitle">Kelola data anggota dengan mudah: tambah, ubah, dan hapus informasi.</p>
            </div>
            <button class="btn btn-accent shadow-sm" @click="openModal()">
                <i class="bi bi-plus-circle me-2"></i> Tambah Anggota
            </button>
        </div>

        <!-- Mini Stats -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="mini-stat">
                    <span class="mini-icon bg-slate"><i class="bi bi-people-fill"></i></span>
                    <div>
                        <div class="mini-value">{{ members.length }}</div>
                        <div class="mini-label">Total Anggota</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="mini-stat">
                    <span class="mini-icon bg-sky"><i class="bi bi-person-plus-fill"></i></span>
                    <div>
                        <div class="mini-value">{{ countThisYear }}</div>
                        <div class="mini-label">Masuk {{ currentYear }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="mini-stat">
                    <span class="mini-icon bg-green"><i class="bi bi-mortarboard-fill"></i></span>
                    <div>
                        <div class="mini-value">{{ countLulus }}</div>
                        <div class="mini-label">Lulus Madrasah</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="mini-stat">
                    <span class="mini-icon bg-amber"><i class="bi bi-building-fill"></i></span>
                    <div>
                        <div class="mini-value">{{ countKampus }}</div>
                        <div class="mini-label">Berkampus</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card card-pro border-0">
            <!-- Toolbar -->
            <div class="card-toolbar">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        class="form-control"
                        v-model="search"
                        placeholder="Cari nama, kampus, wali, atau pekerjaan...">
                    <button v-if="search" class="clear-search" @click="search = ''" title="Bersihkan">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small d-none d-md-inline">
                        <i class="bi bi-funnel me-1"></i>{{ filteredMembers.length }} hasil
                    </span>
                    <button class="btn btn-light btn-sm" @click="fetchMembers" title="Muat ulang">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <div v-if="filteredMembers.length > 0" class="table-responsive">
                    <table class="table table-pro table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th @click="sortBy('id')" class="sortable" style="width: 9%">
                                    ID <i class="bi" :class="sortIcon('id')"></i>
                                </th>
                                <th @click="sortBy('nama')" class="sortable" style="width: 22%">
                                    <i class="bi bi-person me-1"></i>Nama <i class="bi" :class="sortIcon('nama')"></i>
                                </th>
                                <th @click="sortBy('tahun_masuk')" class="sortable text-center" style="width: 12%">
                                    <i class="bi bi-calendar-event me-1"></i>Masuk <i class="bi" :class="sortIcon('tahun_masuk')"></i>
                                </th>
                                <th class="text-center" style="width: 10%"><i class="bi bi-mortarboard me-1"></i>Lulus</th>
                                <th style="width: 17%"><i class="bi bi-building me-1"></i>Kampus</th>
                                <th style="width: 15%"><i class="bi bi-person-badge me-1"></i>Wali</th>
                                <th class="text-end" style="width: 15%"><i class="bi bi-gear me-1"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="member in filteredMembers" :key="member.id">
                                <td><span class="badge bg-slate">{{ member.id }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="row-avatar">{{ initial(member.nama) }}</span>
                                        <div>
                                            <div class="fw-600">{{ member.nama }}</div>
                                            <small class="text-muted" v-if="member.job">
                                                <i class="bi bi-briefcase me-1"></i>{{ member.job }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info-light text-info">{{ member.tahun_masuk }}</span>
                                </td>
                                <td class="text-center">
                                    <span v-if="member.lulus_madrasah" :class="Number(member.lulus_madrasah) <= currentYear ? 'badge bg-success-subtle text-success' : 'badge bg-warning-subtle text-warning'">
                                        <i class="bi me-1" :class="Number(member.lulus_madrasah) <= currentYear ? 'bi-check-circle' : 'bi-hourglass-split'"></i>{{ member.lulus_madrasah }}
                                    </span>
                                    <span v-else class="text-muted">—</span>
                                </td>
                                <td>
                                    <span v-if="member.kampus"><i class="bi bi-building text-muted me-1"></i>{{ member.kampus }}</span>
                                    <span v-else class="text-muted">—</span>
                                </td>
                                <td>{{ member.wali || '—' }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <button class="btn btn-sm btn-outline-secondary" @click="viewMember(member)" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" @click="openModal(member)" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" @click="deleteMember(member.id)" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Empty: no search results -->
                <div v-else-if="search" class="empty-state">
                    <i class="bi bi-search"></i>
                    <p>Tidak ada hasil untuk "{{ search }}"</p>
                    <small class="text-muted">Coba kata kunci lain atau bersihkan pencarian.</small>
                    <div class="mt-3"><button class="btn btn-light btn-sm" @click="search = ''">
                        <i class="bi bi-x-lg me-1"></i>Bersihkan Pencarian</button></div>
                </div>

                <!-- Empty: no data -->
                <div v-else class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada data anggota</p>
                    <small class="text-muted">Klik tombol di bawah untuk mulai menambahkan data.</small>
                    <div class="mt-3"><button class="btn btn-accent btn-sm" @click="openModal()">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Anggota</button></div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        <div class="modal fade" id="memberModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-gradient-slate text-white border-0">
                        <h5 class="modal-title">
                            <i class="bi me-2" :class="editing ? 'bi-pencil-square' : 'bi-person-plus-fill'"></i>
                            {{ editing ? 'Edit Data Anggota' : 'Tambah Anggota Baru' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="saveMember">
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small"><i class="bi bi-hash me-1"></i>ID Anggota</label>
                                    <input type="text" class="form-control" v-model="form.id" :placeholder="editing ? 'ID Anggota' : 'Kosongkan untuk otomatis'">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small"><i class="bi bi-person me-1"></i>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" v-model="form.nama" placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-600 small"><i class="bi bi-calendar-event me-1"></i>Tahun Masuk <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" v-model.number="form.tahun_masuk" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-600 small"><i class="bi bi-mortarboard me-1"></i>Tahun Lulus</label>
                                    <input type="number" class="form-control" v-model.number="form.lulus_madrasah">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-600 small"><i class="bi bi-building me-1"></i>Kampus</label>
                                    <input type="text" class="form-control" v-model="form.kampus">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small"><i class="bi bi-person-badge me-1"></i>Wali</label>
                                    <input type="text" class="form-control" v-model="form.wali">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600 small"><i class="bi bi-briefcase me-1"></i>Pekerjaan</label>
                                    <input type="text" class="form-control" v-model="form.job">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-600 small"><i class="bi bi-geo-alt me-1"></i>Alamat Lengkap</label>
                                    <textarea class="form-control" v-model="form.alamat_lengkap" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 bg-light">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg me-1"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-accent px-4" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                                <i v-else class="bi bi-check-lg me-1"></i>
                                {{ editing ? 'Simpan Perubahan' : 'Tambah Anggota' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" v-if="detail">
                    <div class="modal-header bg-gradient-slate text-white border-0">
                        <h5 class="modal-title"><i class="bi bi-person-vcard me-2"></i>Detail Anggota</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <span class="detail-avatar">{{ initial(detail.nama) }}</span>
                            <h5 class="mt-3 mb-0 fw-bold" style="color:#1e293b;">{{ detail.nama }}</h5>
                            <span class="badge bg-slate mt-1">ID: {{ detail.id }}</span>
                        </div>
                        <ul class="detail-list">
                            <li><i class="bi bi-calendar-event"></i><span>Tahun Masuk</span><strong>{{ detail.tahun_masuk }}</strong></li>
                            <li><i class="bi bi-mortarboard"></i><span>Lulus Madrasah</span><strong>{{ detail.lulus_madrasah || '—' }}</strong></li>
                            <li><i class="bi bi-building"></i><span>Kampus</span><strong>{{ detail.kampus || '—' }}</strong></li>
                            <li><i class="bi bi-person-badge"></i><span>Wali</span><strong>{{ detail.wali || '—' }}</strong></li>
                            <li><i class="bi bi-briefcase"></i><span>Pekerjaan</span><strong>{{ detail.job || '—' }}</strong></li>
                            <li><i class="bi bi-geo-alt"></i><span>Alamat</span><strong>{{ detail.alamat_lengkap || '—' }}</strong></li>
                        </ul>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-accent" @click="editFromDetail">
                            <i class="bi bi-pencil-square me-1"></i>Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

const emptyForm = () => ({
    id: null,
    nama: '',
    tahun_masuk: new Date().getFullYear(),
    lulus_madrasah: '',
    kampus: '',
    wali: '',
    job: '',
    alamat_lengkap: ''
});

export default {
    data() {
        return {
            members: [],
            form: emptyForm(),
            detail: null,
            editing: false,
            originalId: null,
            loading: false,
            search: '',
            sortKey: 'id',
            sortAsc: true,
            modal: null,
            detailModal: null,
            currentYear: new Date().getFullYear()
        }
    },
    computed: {
        filteredMembers() {
            let list = [...this.members];
            const q = this.search.trim().toLowerCase();
            if (q) {
                list = list.filter(m =>
                    [m.nama, m.kampus, m.wali, m.job, String(m.id)]
                        .some(v => (v || '').toString().toLowerCase().includes(q))
                );
            }
            list.sort((a, b) => {
                let x = a[this.sortKey], y = b[this.sortKey];
                if (typeof x === 'string') x = x.toLowerCase();
                if (typeof y === 'string') y = y.toLowerCase();
                if (x < y) return this.sortAsc ? -1 : 1;
                if (x > y) return this.sortAsc ? 1 : -1;
                return 0;
            });
            return list;
        },
        countThisYear() {
            return this.members.filter(m => Number(m.tahun_masuk) === this.currentYear).length;
        },
        countLulus() {
            return this.members.filter(m => m.lulus_madrasah && Number(m.lulus_madrasah) <= this.currentYear).length;
        },
        countKampus() {
            return this.members.filter(m => m.kampus && m.kampus.trim() !== '').length;
        }
    },
    mounted() {
        this.fetchMembers();
        this.modal = new Modal(document.getElementById('memberModal'));
        this.detailModal = new Modal(document.getElementById('detailModal'));
    },
    methods: {
        initial(name) {
            return (name || '?').trim().charAt(0).toUpperCase();
        },
        sortBy(key) {
            if (this.sortKey === key) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortKey = key;
                this.sortAsc = true;
            }
        },
        sortIcon(key) {
            if (this.sortKey !== key) return 'bi-arrow-down-up text-muted opacity-50';
            return this.sortAsc ? 'bi-sort-down-alt' : 'bi-sort-up-alt';
        },
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
                this.originalId = member.id;
            } else {
                this.editing = false;
                this.form = emptyForm();
                this.originalId = null;
            }
            this.modal.show();
        },
        viewMember(member) {
            this.detail = { ...member };
            this.detailModal.show();
        },
        editFromDetail() {
            this.detailModal.hide();
            this.openModal(this.detail);
        },
        async saveMember() {
            this.loading = true;
            try {
                if (this.editing) {
                    await axios.put(`/api/members/${this.originalId}`, this.form);
                } else {
                    await axios.post('/api/members', this.form);
                }
                await this.fetchMembers();
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
.member-management-container { background: transparent; }

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    flex-wrap: wrap;
}
.section-title { font-size: 1.35rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
.section-subtitle { font-size: .9rem; color: #64748b; margin: 0; }

/* Mini stats */
.mini-stat {
    display: flex; align-items: center; gap: .85rem;
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1rem 1.1rem; height: 100%;
    transition: all .2s ease;
}
.mini-stat:hover { box-shadow: 0 6px 16px rgba(15,23,42,.07); transform: translateY(-2px); }
.mini-icon {
    width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
    display: inline-flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.25rem;
}
.mini-icon.bg-slate { background: linear-gradient(135deg, #475569, #0f172a); }
.mini-icon.bg-sky   { background: linear-gradient(135deg, #38bdf8, #0ea5e9); }
.mini-icon.bg-green { background: linear-gradient(135deg, #22c55e, #16a34a); }
.mini-icon.bg-amber { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
.mini-value { font-size: 1.4rem; font-weight: 800; color: #1e293b; line-height: 1; }
.mini-label { font-size: .78rem; color: #64748b; font-weight: 500; }

/* Card */
.card-pro {
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 1px 3px rgba(15,23,42,.05);
    overflow: hidden;
}

/* Toolbar */
.card-toolbar {
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
    flex-wrap: wrap;
}
.search-box { position: relative; flex: 1; min-width: 220px; max-width: 420px; }
.search-box > i.bi-search {
    position: absolute; left: .9rem; top: 50%; transform: translateY(-50%);
    color: #94a3b8; pointer-events: none;
}
.search-box .form-control {
    padding-left: 2.5rem; padding-right: 2.3rem;
    border-radius: 10px; border: 1px solid #e2e8f0;
}
.search-box .form-control:focus {
    border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15);
}
.clear-search {
    position: absolute; right: .5rem; top: 50%; transform: translateY(-50%);
    background: none; border: none; color: #94a3b8; padding: .25rem .4rem; cursor: pointer;
    font-size: .85rem;
}
.clear-search:hover { color: #475569; }

/* Table */
.table-pro { font-size: .9rem; }
.table-pro thead { background: #f8fafc; }
.table-pro thead th {
    color: #475569; font-weight: 700; text-transform: uppercase;
    font-size: .72rem; letter-spacing: .5px;
    padding: .85rem 1.1rem; border: none; border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.table-pro thead th.sortable { cursor: pointer; user-select: none; }
.table-pro thead th.sortable:hover { color: #0f172a; }
.table-pro tbody tr { transition: background .15s ease; border-bottom: 1px solid #f1f5f9; }
.table-pro tbody tr:hover { background: #f8fafc; }
.table-pro tbody td { padding: .8rem 1.1rem; color: #334155; }
.fw-600 { font-weight: 600; color: #1e293b; }

.row-avatar {
    width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
    display: inline-flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #475569, #1e293b);
    color: #fff; font-weight: 700; font-size: .8rem;
}

.badge { font-weight: 600; font-size: .73rem; padding: .4rem .6rem; }
.bg-slate { background-color: #475569 !important; color: #fff; }
.bg-info-light { background-color: #e0f2fe !important; }

/* Empty state */
.empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
.empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: .4; display: block; }
.empty-state p { font-size: 1.1rem; font-weight: 600; margin-bottom: .25rem; color: #475569; }

/* Forms */
.form-label { margin-bottom: 6px; color: #334155; }
.form-control {
    border: 1px solid #e2e8f0; border-radius: 9px;
    padding: .55rem .75rem; font-size: .9rem; transition: all .2s ease;
}
.form-control:focus {
    border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.15); outline: none;
}

/* Buttons */
.btn-accent {
    background: linear-gradient(135deg, #38bdf8, #0ea5e9);
    border: none; color: #fff; font-weight: 600;
    transition: all .25s ease;
}
.btn-accent:hover {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #fff; transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(14,165,233,.35);
}
.btn-accent:disabled { opacity: .65; transform: none; }

/* Modal */
.bg-gradient-slate { background: linear-gradient(135deg, #334155 0%, #0f172a 100%); }
.modal-content { border-radius: 14px; overflow: hidden; }
.modal-header { padding: 1.1rem 1.4rem; }
.modal-footer { padding: 1rem 1.4rem; }

/* Detail modal */
.detail-avatar {
    width: 72px; height: 72px; border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #475569, #0f172a);
    color: #fff; font-weight: 800; font-size: 1.8rem;
}
.detail-list { list-style: none; padding: 0; margin: 0; }
.detail-list li {
    display: flex; align-items: center; gap: .75rem;
    padding: .7rem 0; border-bottom: 1px solid #f1f5f9;
}
.detail-list li:last-child { border-bottom: none; }
.detail-list li i { color: #0ea5e9; width: 1.3rem; text-align: center; }
.detail-list li span { color: #64748b; font-size: .88rem; flex: 1; }
.detail-list li strong { color: #1e293b; font-weight: 600; text-align: right; }
</style>
