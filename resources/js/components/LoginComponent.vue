<template>
    <div class="card shadow-sm border-0 rounded-lg mt-5">
        <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
        <div class="card-body">
            <form @submit.prevent="handleLogin">
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputEmail" type="email" v-model="form.email" placeholder="name@example.com" required />
                    <label for="inputEmail">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputPassword" type="password" v-model="form.password" placeholder="Password" required />
                    <label for="inputPassword">Password</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" id="inputRememberPassword" type="checkbox" v-model="form.remember" />
                    <label class="form-check-input" for="inputRememberPassword">Remember Password</label>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    <a class="small" href="#">Forgot Password?</a>
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Login
                    </button>
                </div>
            </form>
            <div v-if="error" class="alert alert-danger mt-3">
                {{ error }}
            </div>
        </div>
        <div class="card-footer text-center py-3">
            <div class="small"><a href="#">Need an account? Sign up!</a></div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
                remember: false
            },
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
                this.error = err.response?.data?.message || 'Something went wrong. Please try again.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
