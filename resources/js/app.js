import './bootstrap';

import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import MemberManagement from './components/MemberManagement.vue';

const app = createApp({
    data() {
        return {
            sidebarOpen: false,      // off-canvas (mobile)
            sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === '1', // rail mode (desktop)
        };
    },
    methods: {
        toggleSidebar() {
            // Di layar kecil: buka/tutup off-canvas. Di desktop: ciutkan jadi rail.
            if (window.matchMedia('(max-width: 991.98px)').matches) {
                this.sidebarOpen = !this.sidebarOpen;
            } else {
                this.sidebarCollapsed = !this.sidebarCollapsed;
                localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed ? '1' : '0');
            }
        },
    },
});

app.component('example-component', ExampleComponent);
app.component('login-component', LoginComponent);
app.component('member-management', MemberManagement);

app.mount('#app');
