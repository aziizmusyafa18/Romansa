<template>
    <div class="auth-card">
        <div class="auth-card-header">
            <h3>Selamat Datang</h3>
            <p>Silakan masuk untuk melanjutkan ke dashboard</p>
        </div>

        <div class="auth-card-body">
            <form @submit.prevent="handleLogin">
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Alamat Email</label>
                    <div class="input-icon">
                        <i class="bi bi-envelope"></i>
                        <input
                            class="form-control"
                            id="inputEmail"
                            type="email"
                            v-model="form.email"
                            placeholder="nama@email.com"
                            autocomplete="email"
                            required />
                    </div>
                </div>

                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Kata Sandi</label>
                    <div class="input-icon">
                        <i class="bi bi-lock"></i>
                        <input
                            class="form-control"
                            id="inputPassword"
                            :type="showPassword ? 'text' : 'password'"
                            v-model="form.password"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required />
                        <button type="button" class="toggle-pass" @click="showPassword = !showPassword" tabindex="-1">
                            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" id="inputRemember" type="checkbox" v-model="form.remember" />
                        <label class="form-check-label small" for="inputRemember">Ingat saya</label>
                    </div>
                    <a class="small text-decoration-none link-accent" href="#">Lupa sandi?</a>
                </div>

                <transition name="fade">
                    <div v-if="error" class="alert alert-danger d-flex align-items-center py-2 mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <span class="small">{{ error }}</span>
                    </div>
                </transition>

                <button type="submit" class="btn btn-primary w-100 py-2" :disabled="loading">
                    <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    {{ loading ? 'Memproses...' : 'Masuk' }}
                </button>
            </form>
        </div>

        <div class="auth-card-footer">
            <span class="small text-muted">Belum punya akun? Hubungi administrator.</span>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: { email: '', password: '', remember: false },
            showPassword: false,
            loading: false,
            error: null
        }
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.post('/login', this.form);
                window.location.href = response.data.redirect;
            } catch (err) {
                this.error = err.response?.data?.message || 'Terjadi kesalahan. Silakan coba lagi.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>

<style scoped>
.auth-card-header {
    padding: 1.75rem 2rem 0.5rem;
    text-align: center;
}
.auth-card-header h3 {
    font-weight: 800;
    color: #1e293b;
    font-size: 1.4rem;
    margin: 0;
}
.auth-card-header p {
    color: #64748b;
    font-size: 0.88rem;
    margin: 0.4rem 0 0;
}
.auth-card-body { padding: 1.5rem 2rem 0.5rem; }
.auth-card-footer {
    padding: 1.25rem 2rem 1.75rem;
    text-align: center;
    border-top: 1px solid #f1f5f9;
    margin-top: 1rem;
}

.form-label {
    font-weight: 600;
    font-size: 0.82rem;
    color: #334155;
    margin-bottom: 0.4rem;
}

.input-icon { position: relative; }
.input-icon > i {
    position: absolute;
    left: 0.95rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1rem;
    pointer-events: none;
}
.input-icon .form-control {
    padding-left: 2.7rem;
    padding-top: 0.65rem;
    padding-bottom: 0.65rem;
}
.toggle-pass {
    position: absolute;
    right: 0.6rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #94a3b8;
    padding: 0.25rem 0.5rem;
    cursor: pointer;
}
.toggle-pass:hover { color: #475569; }

.link-accent { color: #0ea5e9; }
.link-accent:hover { color: #0284c7; }

.fade-enter-active, .fade-leave-active { transition: opacity 0.2s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
